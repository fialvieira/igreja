<?php

namespace modelo;

use bd\My;

class DocumentoTipo {

    private $id;
    private $descricao;
    private $path_modelo;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $ativo;

    /**
     * DocumentoTipo constructor. 
     * @param $id  
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $c = My::con();
            $r = $c->query("CALL documento_tipo_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->descricao = $l["descricao"];
                $this->path_modelo = $l["path_modelo"];
                $this->empresa_id_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->ativo = $l["ativo"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getPathModelo() {
        return $this->path_modelo;
    }

    /**
     * @param mixed $path_modelo
     */
    public function setPathModelo($path_modelo) {
        $this->path_modelo = $path_modelo;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId() {
        return \bd\Formatos::inteiro($this->empresa_id);
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id) {
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return \bd\Formatos::inteiro($this->user_id);
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = \bd\Formatos::inteiro($user_id);
    }

    /**
     * @return mixed
     */
    public function getCreated() {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created) {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified() {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified) {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    /**
     * @return mixed
     */
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function salva() {
        $c = My::con();
        if (!$this->descricao) {
            throw new \Exception("Descrição obrigatória.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL documento_tipo_altera(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "isssiiss", $this->id, $this->descricao, $this->path_modelo, $this->ativo, $this->empresa_id, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL documento_tipo_insere(?,?,?,?,?,?)");
            $com->bind_param(
                    "ssiiss", $this->descricao, $this->path_modelo, $this->empresa_id, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function seleciona($ativo = NULL, $tem_modelo = NULL) {
        $c = My::con();
        $empresa = EMPRESA;
        if (!isset($ativo) || $ativo == "" || is_null($ativo)) {
            $ativo = "T";
        }
//    $r = $c->query("CALL documento_tipos_seleciona('$ativo',$empresa)");
        $com = $c->prepare("CALL documento_tipos_seleciona(?,?,?)");
        $com->bind_param(
                "sis", $ativo, $empresa, $tem_modelo
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

}

?>