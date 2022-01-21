<?php

namespace modelo;

use bd\My;

class Documento {

    private $id;
    private $num;
    private $data;
    private $hora;
    private $tipo_documento;
    private $tipo_desc;
    private $presidencia;
    private $presidencia_nome;
    private $membros;
    private $igreja_destino_id;
    private $igreja_destino;
    private $pastor_destino_id;
    private $pastor_destino;
    private $secretario;
    private $secretario_nome;
    private $extensao;
    private $ata_id;
    private $ata_num;
    private $data_ata;
    private $data_carta;
    private $documento_ft;
    private $path_arquivo;
    private $finalizado;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * Documento constructor. 
     * @param $id  
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $c = My::con();
            $r = $c->query("CALL documento_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->num = $l["num"];
                $this->data = $l["data"];
                $this->hora = $l["hora"];
                $this->tipo_documento = $l["tipo_documento"];
                $this->tipo_desc = $l["tipo_desc"];
                $this->presidencia = $l["presidencia"];
                $this->presidencia_nome = $l["presidencia_nome"];
                $this->membros = $l["membros"];
                $this->igreja_destino_id = $l["igreja_destino_id"];
                $this->igreja_destino = $l["igreja_destino"];
                $this->pastor_destino_id = $l["pastor_destino_id"];
                $this->pastor_destino = $l["pastor_destino"];
                $this->secretario = $l["secretario"];
                $this->secretario_nome = $l["secretario_nome"];
                $this->extensao = $l["extensao"];
                $this->ata_id = $l["ata_id"];
                $this->ata_num = $l["ata_num"];
                $this->data_ata = $l["data_ata"];
                $this->data_carta = $l["data_carta"];
                $this->documento_ft = $l["documento_ft"];
                $this->path_arquivo = $l["path_arquivo"];
                $this->finalizado = $l["finalizado"];
                $this->user_id = $l["user_id"];
                $this->empresa_id = $l["empresa_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
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
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getNum() {
        return $this->num;
    }

    /**
     * @param mixed $num
     */
    public function setNum($num) {
        $this->num = \bd\Formatos::inteiro($num);
    }

    /**
     * @return mixed
     */
    public function getData() {
        return \bd\Formatos::dataApp($this->data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = \bd\Formatos::dataBd($data);
    }

    /**
     * @return mixed
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora) {
        $this->hora = $hora;
    }

    /**
     * @return mixed
     */
    public function getTipoDocumento() {
        return $this->tipo_documento;
    }

    /**
     * @param mixed $tipo_documento
     */
    public function setTipoDocumento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return mixed
     */
    public function getTipoDesc() {
        return $this->tipo_desc;
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
        $this->user_id = \bd\Formatos::inteiro($user_id);
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
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
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
    public function getDocumentoFt() {
        return $this->documento_ft;
    }

    /**
     * @param mixed $documento_ft
     */
    public function setDocumentoFt($documento_ft) {
        $this->documento_ft = $documento_ft;
    }

    /**
     * @return mixed
     */
    public function getPresidencia() {
        return $this->presidencia;
    }

    /**
     * @param mixed $presidencia
     */
    public function setPresidencia($presidencia) {
        $this->presidencia = $presidencia;
    }

    /**
     * @return mixed
     */
    public function getMembros() {
        return $this->membros;
    }

    /**
     * @param mixed $membros
     */
    public function setMembros($membros) {
        $this->membros = $membros;
    }

    /**
     * @return mixed
     */
    public function getSecretario() {
        return $this->secretario;
    }

    /**
     * @param mixed $secretario
     */
    public function setSecretario($secretario) {
        $this->secretario = $secretario;
    }

    /**
     * @return mixed
     */
    public function getIgrejaDestinoId() {
        return $this->igreja_destino_id;
    }

    /**
     * @param mixed $igreja_destino_id
     */
    public function setIgrejaDestinoId($igreja_destino_id) {
        $this->igreja_destino_id = $igreja_destino_id;
    }

    /**
     * @return mixed
     */
    public function getPastorDestinoId() {
        return $this->pastor_destino_id;
    }

    /**
     * @param mixed $pastor_destino_id
     */
    public function setPastorDestinoId($pastor_destino_id) {
        $this->pastor_destino_id = $pastor_destino_id;
    }

    /**
     * @return mixed
     */
    public function getPathArquivo() {
        return $this->path_arquivo;
    }

    /**
     * @param mixed $path_arquivo
     */
    public function setPathArquivo($path_arquivo) {
        $this->path_arquivo = $path_arquivo;
    }

    /**
     * @return mixed
     */
    public function getExtensao() {
        return $this->extensao;
    }

    /**
     * @param mixed $extensao
     */
    public function setExtensao($extensao) {
        $this->extensao = $extensao;
    }

    /**
     * @return mixed
     */
    public function getDataCarta() {
        return \bd\Formatos::dataApp($this->data_carta);
    }

    /**
     * @param mixed $data_carta
     */
    public function setDataCarta($data_carta) {
        $this->data_carta = \bd\Formatos::dataBd($data_carta);
    }

    /**
     * @return mixed
     */
    public function getAtaId() {
        return $this->ata_id;
    }

    /**
     * @param mixed $ata_id
     */
    public function setAtaId($ata_id) {
        $this->ata_id = $ata_id;
    }

    /**
     * @return mixed
     */
    public function getFinalizado() {
        return $this->finalizado;
    }

    /**
     * @param mixed $finalizado
     */
    public function setFinalizado($finalizado) {
        $this->finalizado = $finalizado;
    }

    /**
     * @return mixed
     */
    public function getPresidenciaNome() {
        return $this->presidencia_nome;
    }

    /**
     * @return mixed
     */
    public function getSecretarioNome() {
        return $this->secretario_nome;
    }

    /**
     * @return mixed
     */
    public function getIgrejaDestino() {
        return $this->igreja_destino;
    }

    /**
     * @return mixed
     */
    public function getPastorDestino() {
        return $this->pastor_destino;
    }

    /**
     * @return mixed
     */
    public function getDataAta() {
        return \bd\Formatos::dataApp($this->data_ata);
    }

    /**
     * @return mixed
     */
    public function getAtaNum() {
        return $this->ata_num;
    }

    public function salva() {
        $c = My::con();

        if ($this->id) {
            $com = $c->prepare("CALL documento_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "issiisiiissssisiiss", $this->id, $this->data, $this->hora, $this->tipo_documento, $this->presidencia, $this->membros, $this->igreja_destino_id, $this->pastor_destino_id, $this->secretario, $this->documento_ft, $this->finalizado, $this->path_arquivo, $this->extensao, $this->ata_id, $this->data_carta, $this->user_id, $this->empresa_id, $this->created, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL documento_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "ssiisiiisssisiiss", $this->data, $this->hora, $this->tipo_documento, $this->presidencia, $this->membros, $this->igreja_destino_id, $this->pastor_destino_id, $this->secretario, $this->documento_ft, $this->path_arquivo, $this->extensao, $this->ata_id, $this->data_carta, $this->user_id, $this->empresa_id, $this->created, $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];
            $this->num = $l["num"];

            $c->next_result();
        }
    }

    public static function exclui($id) {
        $c = My::con();
        if (!is_null($id) && $id != '') {
            $empresa = EMPRESA;
            $com = $c->prepare("CALL documento_exclui(?,?)");
            $com->bind_param(
                    "ii", $id, $empresa
            );
            $com->execute();
        }
    }

    public static function seleciona($valor = null) {
        $c = My::con();
        if ($valor == "" || !isset($valor) || is_null($valor)) {
            $r = $c->query('CALL documentos_seleciona(' . EMPRESA . ')');
        } else {
            $r = $c->query("CALL documentos_fulltext_seleciona('$valor'," . EMPRESA . ")");
        }
        $retorno = [];
        $c->next_result();
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function selecionaPorNum($num) {
        $c = My::con();

        $r = $c->query("SELECT id 
                    FROM documentos
                    WHERE num = $num
                      AND empresa_id = " . EMPRESA);
        $l = $r->fetch_assoc();
        return $l;
    }

}

?>