<?php

namespace modelo;

use bd\My;

class Contato {
  private $id;
  private $nome;
  private $email;
  private $telefone;
  private $congregacao_id;
  private $empresa_id;
  private $user_id;
  private $created;
  private $modified;

  /**
   * Contato constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL contato_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->nome = $l["nome"];
        $this->email = $l["email"];
        $this->telefone = $l["telefone"];
        $this->congregacao_id = $l["congregacao_id"];
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
  public function getEmail() {
    return \bd\Formatos::email($this->email);
  }
  
  /**
   * @param mixed $email
   */
  public function setEmail($email) {
    $this->email = \bd\Formatos::email($email);
  }

  /**
  * @return mixed
  */
  public function getTelefone() {
    return \bd\Formatos::telefoneApp($this->telefone);
  }
  
  /**
   * @param mixed $telefone
   */
  public function setTelefone($telefone) {
    $this->telefone = \bd\Formatos::telefoneBd($telefone);
  }

  /**
  * @return mixed
  */
  public function getCongregacaoId() {
    return \bd\Formatos::inteiro($this->congregacao_id);
  }
  
  /**
   * @param mixed $congregacao_id
   */
  public function setCongregacaoId($congregacao_id) {
    $this->congregacao_id = \bd\Formatos::inteiro($congregacao_id);
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

    if (!$this->congregacao_id) {
      throw new \Exception("Congregacao Id obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL contato_altera(?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "isssiiiss",
              $this->id,
              $this->nome,
              $this->email,
              $this->telefone,
              $this->congregacao_id,
              $this->empresa_id,
              $this->user_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL contato_insere(?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "sssiiiss", 
              $this->nome,
              $this->email,
              $this->telefone,
              $this->congregacao_id,
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
      $r = $c->query("CALL contatos_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL contatos_fulltext_seleciona($valor,EMPRESA)");
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