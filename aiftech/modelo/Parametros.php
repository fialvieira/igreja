<?php

namespace modelo;

use bd\My;

class Parametros {

    private $id;
    private $empresa_id;
    private $idade_quorum;
    private $id_presidentes_ata;
    private $id_secretarios_ata;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Parametros constructor.
     * @param 
     * @throws \Exception
     */
    public function __construct() {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("CALL parametro_seleciona($empresa)");
        $l = $r->fetch_assoc();
        if ($l) {
            $this->id = $l["id"];
            $this->empresa_id = $empresa;
            $this->idade_quorum = $l["idade_quorum"];
            $this->id_presidentes_ata = $l["id_presidentes_ata"];
            $this->id_secretarios_ata = $l["id_secretarios_ata"];
            $this->user_id = $l["user_id"];
            $this->created = $l["created"];
            $this->modified = $l["modified"];
        }
        $c->next_result();
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
    public function getEmpresaId() {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    /**
     * @return mixed
     */
    public function getIdadeQuorum() {
        return $this->idade_quorum;
    }

    /**
     * @param mixed $idade_quorum
     */
    public function setIdadeQuorum($idade_quorum) {
        $this->idade_quorum = $idade_quorum;
    }

    /**
     * @return mixed
     */
    public function getIdPresidentesAta() {
        return $this->id_presidentes_ata;
    }

    /**
     * @param mixed $id_presidentes_ata
     */
    public function setIdPresidentesAta($id_presidentes_ata) {
        $this->id_presidentes_ata = $id_presidentes_ata;
    }

    /**
     * @return mixed
     */
    public function getIdSecretariosAta() {
        return $this->id_secretarios_ata;
    }

    /**
     * @param mixed $id_secretarios_ata
     */
    public function setIdSecretariosAta($id_secretarios_ata) {
        $this->id_secretarios_ata = $id_secretarios_ata;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
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

    public function salva() {
        $c = My::con();
        $empresa = EMPRESA;

        if ($this->id) {
            $com = $c->prepare("CALL parametro_altera(?,?,?,?,?,?)");
            $com->bind_param(
                    "iissis", $this->id, $this->idade_quorum, $this->id_presidentes_ata, $this->id_secretarios_ata, $this->user_id, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL parametro_insere(?,?,?,?,?,?)");
            $com->bind_param(
                    "iissis", $empresa, $this->idade_quorum, $this->id_presidentes_ata, $this->id_secretarios_ata, $this->user_id, $this->created
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];
        }
    }

}

?>