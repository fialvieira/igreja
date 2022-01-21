<?php

class Aut
{

    const PERFIL_MASTER = 1;
    const PERFIL_ADMIN = 2;
    const ADMINISTRATIVO = 3;
    const MEMBRO = 4;
    const PRESIDENTE = 5;
    const VISITANTE = 6;
    const PERFIS = [
        1 => 'MASTER',
        2 => 'ADMIN',
        3 => 'ADMINISTRATIVO',
        4 => 'MEMBRO',
        5 => 'PRESIDENTE',
        6 => 'VISITANTE'
    ];

    /*     * *
     * @var \modelo\Usuario|null
     */

    public static $usuario;
    public static $modulos;
    public static $parametros;

    public static function ini()
    {
        if (isset($_SESSION['usuario'])) {
            self::$usuario = unserialize($_SESSION['usuario']);
        }
        self::$modulos = \modelo\Permissao::selecionaModulos();
        self::$parametros = new modelo\Parametros();
    }

    public static function loga($login, $senha)
    {
        $c = \bd\My::con();

        $query = <<< SQL
          SELECT U.id,
                 U.senha,
                 U.ativo,
                 CU.empresa_id,
                 E.ativo emp_ativo
          FROM users U
          INNER JOIN assoc_empresas_users CU
                  ON U.id = CU.users_id
          INNER JOIN empresas E
                  ON CU.empresa_id = E.id
          WHERE username = ?
SQL;
        $com = $c->prepare($query);
        $com->bind_param('s', $login);
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();

        if (!$l) {
            throw new Exception('Usuário/senha inválidos (1).');
        }
        if ($l['empresa_id'] != EMPRESA) {
            throw new Exception('Usuário/senha inválidos (2).');
        }
        if ($l['ativo'] == 'N') {
            throw new Exception('Usuário/senha inválidos (3).');
        }
        if (password_verify($senha, $l['senha'])) {
            $usuario = new \modelo\Usuario($l['id']);
            if ($usuario->getPerfil() !== self::PERFIL_MASTER && $l['emp_ativo'] !== 'S') {
                throw new Exception('Acesso ao sistema negado, entre em contato para verificarmos.');
            }
            $permissoes = \modelo\Permissao::selecionaPermitido($usuario->getCodigo());
            $usuario->setPermissoes($permissoes);
            self::$usuario = $usuario;
            self::salva();
        } else {
            throw new Exception('Usuário/senha inválidos (4).');
        }
    }

    public static function sai()
    {
        unset($_SESSION['usuario']);
        self::$usuario = null;
        self::$modulos = null;
    }

    public static function salva()
    {
        $_SESSION['usuario'] = serialize(self::$usuario);
    }

    public static function logado()
    {
        return self::$usuario != null;
    }

    public static function filtraLogado()
    {
        if (!self::logado()) {
            throw new Exception('Usuário não logado.');
        }
    }

    public static function temPerfil(...$perfis)
    {
        if (!self::logado()) {
            return false;
        }
        if (is_array($perfis[0])) {
            return in_array(self::$usuario->getPerfil(), $perfis[0]);
        }

        return in_array(self::$usuario->getPerfil(), $perfis);
    }

    public static function filtraPerfil(...$perfis)
    {
        self::filtraLogado();
        if (!self::temPerfil(...$perfis)) {
            throw new Exception('Usuário não autorizado.');
        }
    }

    public static function eMembro($church_id)
    {
        if (!($church_id == EMPRESA)) {
            throw new Exception('Usuário não membro desta igreja.');
        }
    }

    public static function temMenu($menu)
    {
        if (!self::logado()) {
            return false;
        }

        $menus = \modelo\Permissao::selecionaMenus();
        foreach ($menus as $m) {
            if (in_array($menu, $m)) {
                return true;
            }
        }
        return false;
    }

    public static function temAutorizacao(...$modulos)
    {
        if (!self::logado()) {
            return false;
        }
        $permissoes = self::$usuario->getPermissoes();
        if (!empty($permissoes)) {
            foreach ($modulos as $modulo) {
                if (in_array($modulo, array_column($permissoes, 'id_modulo'))) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function filtraAutorizacao(...$modulos)
    {
        self::filtraLogado();
        if (!self::temAutorizacao(...$modulos) && !self::temPerfil(Aut::PERFIL_MASTER)) {
            throw new Exception('Usuário não autorizado.');
        }
    }

    public static function temPermissao($modulo, $permissao)
    {
        if (!self::logado()) {
            return false;
        }
        if (!self::temPerfil(Aut::PERFIL_MASTER)) {
            $array = self::$usuario->getPermissoes();
            $key = array_search($modulo, array_column($array, 'id_modulo'));
            $sel = $array[$key];
            if ($sel['permissao'] >= $permissao) {
                return true;
            }
        } else {
            return true;
        }
        return false;
    }

    public static function filtraPermissao($modulo, $permissao)
    {
        self::filtraLogado();
        if (!self::temPermissao($modulo, $permissao)) {
            throw new Exception('Usuário não autorizado.');
        }
    }

}
