<?php

namespace modelo;

use bd\My;

class Calendario {
  private $id;
  private $datainicio;
  private $assunto;
  private $datafim;
  private $descricao;
  private $empresa_id;
  private $user_id;
  private $modified;
  private $created;
  private $diatodo;
  private $cor;

  /**
   * Calendario constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL calendario_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->datainicio = $l["datainicio"];
        $this->assunto = $l["assunto"];
        $this->datafim = $l["datafim"];
        $this->descricao = $l["descricao"];
        $this->empresa_id = $l["empresa_id"];
        $this->user_id = $l["user_id"];
        $this->modified = $l["modified"];
        $this->created = $l["created"];
        $this->diatodo = $l["diatodo"];
        $this->cor = $l["cor"];
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
  public function getDatainicio() {
    return \bd\Formatos::dataHoraApp($this->datainicio);
  }
  
  /**
   * @param mixed $datainicio
   */
  public function setDatainicio($datainicio) {
    $this->datainicio = \bd\Formatos::dataHoraBd($datainicio);
  }

  /**
  * @return mixed
  */
  public function getAssunto() {
    return $this->assunto;
  }
  
  /**
   * @param mixed $assunto
   */
  public function setAssunto($assunto) {
    $this->assunto = $assunto;
  }

  /**
  * @return mixed
  */
  public function getDatafim() {
    return \bd\Formatos::dataHoraApp($this->datafim);
  }
  
  /**
   * @param mixed $datafim
   */
  public function setDatafim($datafim) {
    $this->datafim = \bd\Formatos::dataHoraBd($datafim);
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
  public function getDiatodo() {
    return \bd\Formatos::inteiro($this->diatodo);
  }
  
  /**
   * @param mixed $diatodo
   */
  public function setDiatodo($diatodo) {
    $this->diatodo = \bd\Formatos::inteiro($diatodo);
  }

  /**
  * @return mixed
  */
  public function getCor() {
    return $this->cor;
  }
  
  /**
   * @param mixed $cor
   */
  public function setCor($cor) {
    $this->cor = $cor;
  }

  public function salva() {
    $c = My::con();
    if ($this->id) {
      $com = $c->prepare("CALL calendario_altera(?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "issssiissis",
              $this->id,
              $this->datainicio,
              $this->assunto,
              $this->datafim,
              $this->descricao,
              $this->empresa_id,
              $this->user_id,
              $this->modified,
              $this->created,
              $this->diatodo,
              $this->cor
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL calendario_insere(?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "ssssiissis", 
              $this->datainicio,
              $this->assunto,
              $this->datafim,
              $this->descricao,
              $this->empresa_id,
              $this->user_id,
              $this->modified,
              $this->created,
              $this->diatodo,
              $this->cor
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
      $r = $c->query("CALL calendarios_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL calendarios_fulltext_seleciona($valor,EMPRESA)");
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