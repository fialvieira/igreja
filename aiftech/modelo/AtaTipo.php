<?php

namespace modelo;

use bd\My;

class AtaTipo {
  private $id;
  private $descricao;
  private $texto_padrao;
  private $cartorio;
  private $empresa_id;
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
      $c = My::con();
      $r = $c->query("CALL ata_tipo_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->descricao = $l["descricao"];
        $this->texto_padrao = $l["texto_padrao"];
        $this->cartorio = $l["cartorio"];
        $this->empresa_id_id = $l["empresa_id"];
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
  public function getTextoPadrao() {
    return $this->texto_padrao;
  }
  
  /**
   * @param mixed $texto_padrao
   */
  public function setTextoPadrao($texto_padrao) {
    $this->texto_padrao = $texto_padrao;
  }
  /**
  * @return mixed
  */
  public function getCartorio() {
    return $this->cartorio;
  }
  
  /**
   * @param mixed $cartorio
   */
  public function setCartorio($cartorio) {
    $this->cartorio = $cartorio;
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
      throw new \Exception("Descrição obrigatória.");
    }
    if (!$this->cartorio) {
      throw new \Exception("Registro Cartório obrigatório.");
    }

    if ($this->id) {
      $com = $c->prepare("CALL ata_tipo_altera(?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "issssiiss",
              $this->id,
              $this->descricao,
              $this->texto_padrao,
              $this->cartorio,
              $this->ativo,
              $this->empresa_id,
              $this->user_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL ata_tipo_insere(?,?,?,?,?,?,?)");
      $com->bind_param(
              "sssiiss", 
              $this->descricao,
              $this->texto_padrao,
              $this->cartorio,
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

  public static function seleciona($ativo = NULL) {
    $c = My::con();
    $empresa = EMPRESA;
    if (!isset($ativo) || $ativo == "" || is_null($ativo)) {
        $ativo = "T";
    }
    $r = $c->query("CALL ata_tipos_seleciona('$ativo',$empresa)");
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }
}
?>