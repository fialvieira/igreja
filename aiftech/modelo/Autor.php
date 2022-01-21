<?php

namespace modelo;

use bd\My;

class Autor {
  private $id;
  private $nome;
  private $empresa_id;
  private $user_id;
  private $created;
  private $modified;

  /**
   * Autor constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL autor_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->nome = $l["nome"];
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
  public function getNome() {
    return $this->nome;
  }
  
  /**
   * @param mixed $nome
   */
  public function setNome($nome) {
    $this->nome = $nome;
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

  public function salva() {
    $c = My::con();
    if (!$this->nome) {
      throw new \Exception("Nome obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL autor_altera(?,?,?,?,?,?)");
      $com->bind_param(
              "isiiss",
              $this->id,
              $this->nome,
              $this->empresa_id,
              $this->user_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL autor_insere(?,?,?,?,?)");
      $com->bind_param(
              "siiss", 
              $this->nome,
              $this->empresa_id,
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

  public static function seleciona($valor = null) {
    $c = My::con();
    if($valor == "" || !isset($valor) || is_null($valor)){
      $r = $c->query("CALL autores_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL autores_fulltext_seleciona($valor,EMPRESA)");
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