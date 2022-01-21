<?php

namespace modelo;

use bd\My;
use Psr\Log\NullLogger;

class Usuario
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

    const STATUS_ATIVO = 'S';
    const STATUS_INATIVO = 'N';
    const STATUS = [
        'S' => 'ATIVO',
        'N' => 'INATIVO',
    ];

    private $codigo;
    private $nome;
    private $cpf;
    private $email;
    private $fone_movel;
    private $usuario;
    private $senha;
    private $perfil;
    private $data_criacao;
    private $data_modificacao;
    private $church;
    private $status;
    private $permissoes;

    /**
     * Usuario constructor.
     * @param $codigo
     * @throws \Exception
     */
    public function __construct($codigo = null)
    {
        if (!is_null($codigo)) {
            $codigo = intval($codigo);
            $c = My::con();
            $r = $c->query("CALL usuario_seleciona($codigo)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->nome = $l['nome'];
                $this->email = $l['email'];
                $this->fone_movel = $l['celular'];
                $this->usuario = $l['username'];
                $this->senha = $l['senha'];
                $this->perfil = $l['perfil'];
                $this->cpf = $l['cpf'];
                $this->data_criacao = $l['created'];
                $this->data_modificacao = $l['modified'];
                $this->church = $l['empresa_id'];
                $this->codigo = $codigo;
                $this->status = $l['ativo'];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * @param mixed $dt_criacao
     */
    public function setCriacao($dt_criacao)
    {
        $this->data_criacao = $dt_criacao;
    }

    /**
     * @return mixed
     */
    public function getModificacao()
    {
        return $this->data_modificacao;
    }

    /**
     * @param mixed $dt_modificacao
     */
    public function setModificacao($dt_modificacao)
    {
        $this->data_modificacao = $dt_modificacao;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->fone_movel;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->fone_movel = $celular;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    /**
     * @return mixed
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @param mixed $perfil
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getChurch()
    {
        return $this->church;
    }

    /**
     * @param mixed $church
     */
    public function setChurch($church)
    {
        $this->church = $church;
    }

    /**
     * @return mixed
     */
    public function getPermissoes()
    {
        return $this->permissoes;
    }

    /**
     * @param mixed $permissoes
     */
    public function setPermissoes($permissoes)
    {
        $this->permissoes = $permissoes;
    }

    public function setUsersChurch()
    {
        $c = My::con();
        $com = $c->prepare('CALL users_empresa_insere(?, ?)');
        $com->bind_param(
            'ii', $this->church, $this->codigo
        );
        $com->execute();
    }

    public function setFullText()
    {
        $c = My::con();
        $com = $c->prepare('SELECT *'
            . ' FROM users'
            . ' WHERE id = ?');
        $com->bind_param('i', $this->codigo);
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();
        if (is_null($l['username']) || $l['username'] == '') {
            $username = '';
        } else {
            $username = $l['username'];
        }
        if (is_null($l['nome']) || $l['nome'] == '') {
            $nome = '';
        } else {
            $nome = $l['nome'];
        }
        if (is_null($l['email']) || $l['email'] == '') {
            $email = '';
        } else {
            $email = $l['email'];
        }
        if (is_null($l['celular']) || $l['celular'] == '') {
            $celular = '';
        } else {
            $celular = $l['celular'];
        }
        if (is_null($l['cpf']) || $l['cpf'] == '') {
            $cpf = '';
        } else {
            $cpf = $l['cpf'];
        }
        if (is_null($l['perfil']) || $l['perfil'] == '') {
            $perfil = '';
        } else {
            $perfil = self::PERFIS[$l['perfil']];
        }
        $str_ft = $username . ' ' . $nome . ' ' . $email . ' ' . $celular . ' ' . $cpf . ' ' . $perfil;
        $query = 'UPDATE users
                  SET users_ft = ?
                  WHERE id = ?';
        $com = $c->prepare($query);
        $com->bind_param('si', $str_ft, $this->codigo);
        $com->execute();
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception('Nome obrigatório.');
        }
        if (!$this->usuario) {
            throw new \Exception('Usuário obrigatório.');
        }
        if ($this->codigo) {
            $query = <<< SQL
                    SELECT users_id,
                           empresa_id
                    FROM assoc_empresas_users
                    WHERE users_id = ?
                      AND empresa_id = ?
SQL;
            $com = $c->prepare($query);
            $com->bind_param('ii', $this->codigo, $this->church);
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            if (!$l) {
                throw new \Exception('Não foi possível salvar alteração!.');
            }
            $com = $c->prepare('CALL usuario_altera(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $com->bind_param(
                'ssissssis', $this->nome, $this->usuario, $this->perfil, $this->cpf, $this->email, $this->fone_movel, $this->data_modificacao, $this->codigo, $this->senha
            );
            $com->execute();
        } else {
            if (!$this->senha) {
                throw new \Exception('Senha obrigatória.');
            }
            /*
              vnome           VARCHAR(100),
              vusuario        VARCHAR(45),
              vsenha          CHAR(64),
              vperfil         TINYINT(4),
              vcpf            VARCHAR(45),
              vemail          VARCHAR(100),
              vcelular        VARCHAR(45),
              vcriacao        DATETIME,
              vmodificacao    DATETIME
             */
            $com = $c->prepare('CALL usuario_insere(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $com->bind_param(
                'sssisssss', $this->nome, $this->usuario, $this->senha, $this->perfil, $this->cpf, $this->email, $this->fone_movel, $this->data_criacao, $this->data_modificacao
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->codigo = $l['id'];
            $c->next_result();
            $this->setUsersChurch();
        }
    }

    public function excluirUsuario($tipo)
    {
        $c = My::con();
        if ($tipo == 'd') {
            /*       * Excluir registro da tabela associativa* */
            $query = 'DELETE
                FROM assoc_empresas_users
                WHERE empresa_id = ?
                  AND users_id = ?';
            $com = $c->prepare($query);
            $com->bind_param('ii', $this->church, $this->codigo);
            $com->execute();

            /*       * Excluir registro da tabela mãe* */
            $query = 'DELETE
                FROM users
                WHERE id = ?';
            $com = $c->prepare($query);
            $com->bind_param('i', $this->codigo);
            $com->execute();
        } else {
            $query = "UPDATE users
                SET ativo = 'N'
                WHERE id = $this->codigo";
            $com = $c->query($query);
        }
    }

    public function ativarUsuario()
    {
        $c = My::con();
        $query = "UPDATE users
            SET ativo = 'S'
            WHERE id = $this->codigo";
        $com = $c->query($query);
    }

    public static function seleciona($church_id, $pesquisa = NULL, $status = NULL)
    {
        $c = My::con();
        if ($status == '' || !isset($status) || is_null($status)) {
            $status = NULL;
        }
        if ($pesquisa == '' || !isset($pesquisa) || is_null($pesquisa)) {
            $query = 'CALL usuarios_seleciona(?, ?)';
            $com = $c->prepare($query);
            $com->bind_param('is', $church_id, $status);
            $com->execute();
            $r = $com->get_result();
        } else {
            $query = ('CALL users_ft_seleciona(?, ?, ?)');
            $com = $c->prepare($query);
            $com->bind_param('sis', $pesquisa, $church_id, $status);
            $com->execute();
            $r = $com->get_result();
        }
        $usuarios = [];
        while ($l = $r->fetch_assoc()) {
            $usuarios[] = $l;
        }
        $c->next_result();
        return $usuarios;
    }

    public static function listaUsuariosPorPerfil($status = NULL, $perfil = Null)
    {
        $c = My::con();
        $status = ($status == '' || !isset($status) || is_null($status)) ? null : $status;
        $church_id = EMPRESA;
        $perfil = ($status == '' || !isset($status) || is_null($status)) ? null : $perfil;
        $query = 'CALL usuarios_perfil_seleciona(?, ?, ?)';
        $com = $c->prepare($query);
        $com->bind_param('isi', $church_id, $status, $perfil);
        $com->execute();
        $r = $com->get_result();
        $usuarios = [];
        while ($l = $r->fetch_assoc()) {
            $usuarios[] = $l;
        }
        $c->next_result();
        return $usuarios;
    }

    public static function getIdUsuarioPorCPF($cpf)
    {
        if ($cpf != '' || isset($cpf)) {
            $c = My::con();
            $query = 'SELECT id, senha
                FROM users
                WHERE cpf = ?';
            $com = $c->prepare($query);
            $com->bind_param('s', $cpf);
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $id = $l['id'];
            if ($id != '') {
                $ret = [
                    'USUARIO' => true,
                    'id' => $id,
                    'senha' => $l['senha']
                ];
            } else {
                $ret = [
                    'USUARIO' => false,
                    'id' => '',
                    'senha' => ''
                ];
            }
        } else {
            $ret = [
                'USUARIO' => false,
                'id' => '',
                'senha' => ''
            ];
        }
//    $c->next_result();
        return $ret;
    }

    public static function existeLogin($login = NULL, $cpf = NULL, $email = NULL)
    {
        $c = My::con();
        $empresa = EMPRESA;

        if (is_null($email)) {
            if ($login != '' || isset($login)) {
                $login = strtoupper($login);
                $query = 'SELECT U.username
                  FROM users U
                  INNER JOIN assoc_empresas_users EU  
                          ON U.id = EU.users_id
                  WHERE UPPER(U.username) = ?
                    AND EU.empresa_id = ?';
                $com = $c->prepare($query);
                $com->bind_param('si', $login, $empresa);
                $com->execute();
                $r = $com->get_result();
                $l = $r->fetch_assoc();

                if ($l) {
                    $ret = TRUE;
                } else {
                    $ret = FALSE;
                }
            }
        } else {
            $login = ($login != '') ? strtoupper($login) : NULL;
            $cpf = ($cpf != '') ? \bd\Formatos::cpfBd($cpf) : NULL;

            $query = "SELECT U.id, U.username, U.cpf, U.email
                FROM users U
                INNER JOIN assoc_empresas_users EU  
                        ON U.id = EU.users_id												
                WHERE UPPER(U.username) = CASE WHEN '$login' = '' THEN UPPER(U.username) ELSE '$login' END
                  AND U.cpf = CASE WHEN '$cpf' = '' THEN U.cpf ELSE '$cpf' END
                  AND U.email = '$email'
                  AND EU.empresa_id = $empresa;";
            $r = $c->query($query);
            $l = $r->fetch_assoc();
            $ret = $l;
        }

        return $ret;
    }
}