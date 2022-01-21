<?php

namespace modelo;

use bd\My;

class Escolaridade {
  private $id;
  private $descricao;
  private $obs;
  private $created;
  private $modified;
  private $user_id;

  /**
   * Escolaridade constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL escolaridade_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->descricao = $l["descricao"];
        $this->obs = $l["obs"];
        $this->created = $l["created"];
        $this->modified = $l["modified"];
        $this->user_id = $l["user_id"];
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
  public function getObs() {
    return $this->obs;
  }
  
  /**
   * @param mixed $obs
   */
  public function setObs($obs) {
    $this->obs = $obs;
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
  public function getUserId() {
    return \bd\Formatos::inteiro($this->user_id);
  }
  
  /**
   * @param mixed $user_id
   */
  public function setUserId($user_id) {
    $this->user_id = \bd\Formatos::inteiro($user_id);
  }

  public function salva() {
    $c = My::con();
    if (!$this->descricao) {
      throw new \Exception("Descricao obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL escolaridade_altera(?,?,?,?,?,?)");
      $com->bind_param(
              "issssi",
              $this->id,
              $this->descricao,
              $this->obs,
              $this->created,
              $this->modified,
              $this->user_id
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL escolaridade_insere(?,?,?,?,?)");
      $com->bind_param(
              "ssssi", 
              $this->descricao,
              $this->obs,
              $this->created,
              $this->modified,
              $this->user_id
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
      $r = $c->query("CALL escolaridades_seleciona()");
    }else{
      $r = $c->query("CALL escolaridades_fulltext_seleciona($valor)");
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