<?php

namespace modelo;

use bd\My;

class TipoFornecedor {
  private $id;
  private $descricao;
  private $user_id;
  private $created;
  private $modified;
  private $ativo;
  
  /**
   * TipoFornecedor constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = $id;
      $c = My::con();
      $r = $c->query("CALL tipo_fornecedor_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->descricao = $l["descricao"];
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
      throw new \Exception("Descricao obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL tipo_fornecedor_altera(?,?,?,?,?,?)");
      $com->bind_param(
              "ississ",
              $this->id,
              $this->descricao,
              $this->ativo,
              $this->user_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      
      $com = $c->prepare("CALL tipo_fornecedor_insere(?,?,?,?)");
      $com->bind_param(
              "siss", 
              $this->descricao,
              $this->user_id,
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

  public static function seleciona($ativo = NULL) {
    $c = My::con();
    if (!isset($ativo) || $ativo == "" || is_null($ativo)) {
        $ativo = "S";
    }
    $r = $c->query("CALL tipo_fornecedores_seleciona('$ativo')");
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }
}
?>