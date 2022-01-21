<?php

namespace modelo;

use bd\My;

class CentroCusto {

    private $id;
    private $descricao;
    private $ativo;
    private $principal;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Local constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL centro_custo_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->descricao = $l["descricao"];
                $this->ativo = $l["ativo"];
                $this->principal = ($l["principal"] != '') ? $l["principal"] : 'N';
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
    public function getid() {
        return \bd\Formatos::inteiro($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setid($id) {
        $this->id = \bd\Formatos::inteiro($id);
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
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    /**
     * @return mixed
     */
    public function getPrincipal() {
        return $this->principal;
    }

    /**
     * @param mixed $principal
     */
    public function setPrincipal($principal) {
        $this->principal = $principal;
    }

    /**
     * @return mixed
     */
    public function getEmpresasId() {
        return \bd\Formatos::inteiro($this->empresa_id);
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresasId($empresa_id) {
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

//    public function alteraStatusAtivo()
//    {
//        $c = My::con();
//        if (!$this->ativo) {
//            throw new \Exception("Problemas com envio de parâmetro.");
//        }
//        $com = $c->prepare("CALL local_altera_status(?,?,?,?,?,?)");
//        $com->bind_param(
//            "iisiss",
//            $this->id,
//            $this->empresa_id,
//            $this->ativo,
//            $this->user_id,
//            $this->created,
//            $this->modified
//        );
//        $com->execute();
//    }

    public function alteraCentroPrincipal() {
        $c = My::con();

        if (!$this->principal) {
            throw new \Exception("Problemas com envio de parâmetro.");
        }
        $com = $c->prepare("CALL centro_custo_set_principal(?,?,?,?,?)");
        $com->bind_param(
                "iisis", $this->id, $this->empresa_id, $this->principal, $this->user_id, $this->modified
        );
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();
        
        return $l;
    }

    public static function getCentroPrincipal() {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("SELECT descricao
                        FROM centro_custo
                        WHERE empresa_id = $empresa
                          AND principal = 'S'");
        $l = $r->fetch_assoc();

        return $l;
    }

    public function salva() {
        $c = My::con();
        if (!$this->descricao) {
            throw new \Exception("Descrição obrigatória.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL centro_custo_altera(?,?,?,?,?,?,?)");
            $com->bind_param(
                    "issiiss", $this->id, $this->descricao, $this->ativo, $this->empresa_id, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL centro_custo_insere(?,?,?,?,?)");
            $com->bind_param(
                    "siiss", $this->descricao, $this->empresa_id, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function seleciona($ativo = null) {
        $c = My::con();
        $empresa = EMPRESA;
//        if ($ativo == "" || !isset($ativo) || is_null($ativo)) {
//            $ativo = "S";
//        }
        $r = $c->query("CALL centros_custo_seleciona('$ativo', $empresa)");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

}
