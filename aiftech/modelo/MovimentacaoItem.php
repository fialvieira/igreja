<?php

namespace modelo;

use bd\My;

class MovimentacaoItem {
  private $id;
  private $quantidade;
  private $devolvido;
  private $membro_id;
  private $item_id;
  private $user_id;
  private $empresa_id;
  private $created;
  private $modified;

  /**
   * MovimentacaoItem constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL movimentacao_item_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->quantidade = $l["quantidade"];
        $this->devolvido = $l["devolvido"];
        $this->membro_id = $l["membro_id"];
        $this->item_id = $l["item_id"];
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
  public function getDevolvido() {
    return \bd\Formatos::inteiro($this->devolvido);
  }
  
  /**
   * @param mixed $devolvido
   */
  public function setDevolvido($devolvido) {
    $this->devolvido = \bd\Formatos::inteiro($devolvido);
  }

  /**
  * @return mixed
  */
  public function getMembroId() {
    return \bd\Formatos::inteiro($this->membro_id);
  }
  
  /**
   * @param mixed $membro_id
   */
  public function setMembroId($membro_id) {
    $this->membro_id = \bd\Formatos::inteiro($membro_id);
  }

  /**
  * @return mixed
  */
  public function getItemId() {
    return \bd\Formatos::inteiro($this->item_id);
  }
  
  /**
   * @param mixed $item_id
   */
  public function setItemId($item_id) {
    $this->item_id = \bd\Formatos::inteiro($item_id);
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
    if (!$this->devolvido) {
      throw new \Exception("Devolvido obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL movimentacao_item_altera(?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "iiiiiiiss",
              $this->id,
              $this->quantidade,
              $this->devolvido,
              $this->membro_id,
              $this->item_id,
              $this->user_id,
              $this->empresa_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL movimentacao_item_insere(?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "iiiiiiss", 
              $this->quantidade,
              $this->devolvido,
              $this->membro_id,
              $this->item_id,
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
      $r = $c->query("CALL movimentacao_itens_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL movimentacao_itens_fulltext_seleciona($valor,EMPRESA)");
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