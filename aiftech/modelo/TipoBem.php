<?php

namespace modelo;

use bd\My;

class TipoBem {

  private $id;
  private $nome;
  private $descricao;
  private $ativo;
  private $empresa_id;
  private $user_id;
  private $created;
  private $modified;

  /**
   * TipoBem constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $empresa = EMPRESA;
      $r = $c->query("CALL tipo_bem_seleciona($id,$empresa)");
      $l = $r->fetch_assoc();
      if ($l) {
        $this->id = $id;
        $this->nome = $l["nome"];
        $this->descricao = $l["descricao"];
        $this->ativo = $l["ativo"];
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
  public function getNome() {
    return $this->nome;
  }

  /**
   * @param mixed $nome
   */
  public function setNome($nome) {
    $this->nome = \bd\Formatos::nome($nome);
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
  public function getAtivo() {
    return $this->ativo;
  }

  /**
   * @param mixed $ativo
   */
  public function setAtivo($ativo) {
    $this->ativo = $ativo;
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
      $com = $c->prepare("CALL tipo_bem_altera(?,?,?,?,?,?,?)");
      $com->bind_param(
              "isssiis", $this->id, $this->nome, $this->descricao, $this->ativo, $this->empresa_id, $this->user_id, $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL tipo_bem_insere(?,?,?,?,?)");
      $com->bind_param(
              "ssiis", $this->nome, $this->descricao, $this->empresa_id, $this->user_id, $this->created
      );
      $com->execute();
      $r = $com->get_result();
      $l = $r->fetch_assoc();

      $this->id = $l["id"];

      $c->next_result();
    }
  }

  public static function seleciona($ativo = null) {
    $c = My::con();
    if (is_null($ativo) || !isset($ativo) || $ativo == '') {
      $ativo = 'T';
    } 
    $r = $c->query("CALL tipo_bens_seleciona(".EMPRESA.",'".$ativo."')");
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }

}

?>