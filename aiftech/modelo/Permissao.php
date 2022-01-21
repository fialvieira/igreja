<?php

namespace modelo;

use bd\My;

class Permissao
{

    const VIEWER = 1;
    const WRITE = 2;
    const REWRITE = 3;
    const DEL = 4;
    const PERMISSOES = [
        1 => 'VISUALIZAÇÃO',
        2 => 'VISUALIZAÇÃO / INSERÇÃO',
        3 => 'VISUALIZAÇÃO / INSERÇÃO / EDIÇÃO',
        4 => 'VISUALIZAÇÃO / INSERÇÃO / EDIÇÃO / EXCLUSÃO'
    ];

    private $id;
    private $usuario_id;
    private $usuario;
    private $modulo_id;
    private $menu;
    private $modulo;
    private $permissao;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Local constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id) && $id != '') {
//            $id = $id;
            $c = My::con();
            $r = $c->query("CALL permissao_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->usuario_id = $l["usuario_id"];
                $this->usuario = $l["usuario"];
                $this->modulo_id = $l["modulo_id"];
                $this->menu = $l["menu"];
                $this->modulo = $l["modulo"];
                $this->permissao = $l["permissao"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = \bd\Formatos::inteiro($user_id);
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getModuloId()
    {
        return $this->modulo_id;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getModulo()
    {
        return $this->modulo;
    }

    public function getPermissao()
    {
        return $this->permissao;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function setModuloId($modulo_id)
    {
        $this->modulo_id = $modulo_id;
    }

    public function setPermissao($permissao)
    {
        $this->permissao = $permissao;
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->usuario_id) {
            throw new \Exception("Usuário obrigatório.");
        }
        if (!$this->modulo_id) {
            throw new \Exception("Módulo obrigatório.");
        }
        if (!$this->permissao) {
            throw new \Exception("Permissão obrigatória.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL permissao_altera(?,?,?,?)");
            $com->bind_param(
                "iiis", $this->id, $this->permissao, $this->user_id, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL permissao_insere(?,?,?,?,?,?)");
            $com->bind_param(
                "iiiiis", $this->usuario_id, $this->modulo_id, $this->permissao, $this->empresa_id, $this->user_id,
                $this->created
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public function exclui()
    {
        $c = My::con();
        $r = $c->query("UPDATE permissoes
                          SET user_id = $this->user_id
                        WHERE empresa_id = $this->empresa_id
                          AND id = $this->id");
        $r = $c->query("DELETE
                        FROM permissoes
                        WHERE empresa_id = $this->empresa_id
                          AND id = $this->id");
        return true;
    }

    public static function selecionaPorUsuario($usuario_id)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if (is_null($usuario_id)) {
            $usuario_id = 'NULL';
        }

        $r = $c->query("SELECT mm.menu_id
                              ,m.descricao menu
                              ,mm.id id_modulo
                              ,mm.descricao desc_modulo
                              ,mm.path
                              ,p.id
                              ,p.permissao
                              ,mm.target
                        FROM menu_modulos mm
                        INNER JOIN menus m
                                ON mm.menu_id = m.id
                        LEFT JOIN permissoes p
                               ON mm.id = p.modulo_id
                              AND p.usuario_id = $usuario_id
                              AND p.empresa_id = $empresa
                        ORDER BY mm.menu_id, mm.id");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }

        return $retorno;
    }

    public static function selecionaPermitido($usuario_id)
    {
        $c = My::con();
        $empresa = EMPRESA;

        $r = $c->query("SELECT mm.menu_id
                              ,m.descricao menu
                              ,mm.id id_modulo
                              ,mm.descricao desc_modulo
                              ,mm.path
                              ,p.id
                              ,p.permissao
                              ,mm.target
                        FROM permissoes p
                        INNER JOIN menu_modulos mm
                               ON mm.id = p.modulo_id
                        INNER JOIN menus m
                                ON mm.menu_id = m.id
                        WHERE p.usuario_id = $usuario_id
                          AND p.empresa_id = $empresa
                        ORDER BY mm.menu_id, mm.descricao");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }

        return $retorno;
    }

    public static function usuariosPermissoes()
    {
        $c = My::con();
        $empresa = EMPRESA;

        $r = $c->query("SELECT DISTINCT u.id, u.nome, u.username
                        FROM users u
                        INNER JOIN permissoes p
                                ON u.id = p.usuario_id
                        WHERE p.empresa_id = $empresa
                          AND u.perfil <> 1");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function selecionaMenus()
    {
        $c = My::con();

        $r = $c->query("SELECT *
                        FROM menus");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function selecionaModulos()
    {
        $c = My::con();

        $r = $c->query("SELECT *
                        FROM menu_modulos
                        ORDER BY menu_id, descricao");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $chave = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/",
                "/(Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü)/",
                "/(Ú|Ù|Û|Ü)/",
                "/(ç)/",
                "/(Ç)/",
                "/(ñ)/",
                "/(Ñ)/"
            ), explode(" ", "a A e E i I o O u U c C n N"), $l['descricao']);
            $chave = strtoupper($chave);
            $chave = str_replace(' ', '_', $chave);
            $retorno[$chave] = $l['id'];
        }
        return $retorno;
    }

    public static function seleciontaTodosModulos()
    {
        $c = My::con();

        $r = $c->query("SELECT *
                              FROM menu_modulos
                              ORDER BY menu_id, descricao");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }
}