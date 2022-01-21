<?php

namespace modelo;

use bd\My;

class MovimentacaoBem {
  private $id;
  private $tipo;
  private $quantidade;
  private $membros_id;
  private $motivo;
  private $bem_id;
  private $data_movimentacao;
  private $user_id;
  private $empresa_id;
  private $created;
  private $modified;

  /**
   * MovimentacaoBem constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL movimentacao_bem_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->tipo = $l["tipo"];
        $this->quantidade = $l["quantidade"];
        $this->membros_id = $l["membros_id"];
        $this->motivo = $l["motivo"];
        $this->bem_id = $l["bem_id"];
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
    return \bd\Formatos::inteiro($this->id);
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
  public function getTipo() {
    return \bd\Formatos::inteiro($this->tipo);
  }
  
  /**
   * @param mixed $tipo
   */
  public function setTipo($tipo) {
    $this->tipo = \bd\Formatos::inteiro($tipo);
  }

  /**
  * @return mixed
  */
  public function getQuantidade() {
    return \bd\Formatos::inteiro($this->quantidade);
  }
  
  /**
   * @param mixed $quantidade
   */
  public function setQuantidade($quantidade) {
    $this->quantidade = \bd\Formatos::inteiro($quantidade);
  }

  /**
  * @return mixed
  */
  public function getMembrosId() {
    return \bd\Formatos::inteiro($this->membros_id);
  }
  
  /**
   * @param mixed $membros_id
   */
  public function setMembrosId($membros_id) {
    $this->membros_id = \bd\Formatos::inteiro($membros_id);
  }

  /**
  * @return mixed
  */
  public function getMotivo() {
    return $this->motivo;
  }
  
  /**
   * @param mixed $motivo
   */
  public function setMotivo($motivo) {
    $this->motivo = $motivo;
  }

  /**
  * @return mixed
  */
  public function getBemId() {
    return \bd\Formatos::inteiro($this->bem_id);
  }
  
  /**
   * @param mixed $bem_id
   */
  public function setBemId($bem_id) {
    $this->bem_id = \bd\Formatos::inteiro($bem_id);
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
    if ($this->id) {
      $com = $c->prepare("CALL movimentacao_bem_altera(?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "iiiisiiiss",
              $this->id,
              $this->tipo,
              $this->quantidade,
              $this->membros_id,
              $this->motivo,
              $this->bem_id,
              $this->user_id,
              $this->empresa_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL movimentacao_bem_insere(?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "iiisiiiss", 
              $this->tipo,
              $this->quantidade,
              $this->membros_id,
              $this->motivo,
              $this->bem_id,
              $this->user_id,
              $this->empresa_id,
              $this->created,
              $this->modified
      );
      $com->execute();
      $r = $com->get_result();
      $l = $r->fetch_assoc();
      
      $this->id = $l["id"];
      
      $c->next_result();
    }
  }

  public static function seleciona($valor = null) {
    $c = My::con();
    if($valor == "" || !isset($valor) || is_null($valor)){
      $r = $c->query("CALL movimentacao_bens_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL movimentacao_bens_fulltext_seleciona($valor,EMPRESA)");
    }
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }
}
?>