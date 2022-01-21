<?php

namespace modelo;

use bd\My;

class Bem {
  private $id;
  private $nome;
  private $identificacao;
  private $num_serie;
  private $num_ativo;
  private $marca;
  private $modelo;
  private $descricao;
  private $observacao;
  private $data_compra;
  private $garantia;
  private $valor_unitario;
//  private $quantidade;
  private $departamento_id;
  private $local_id;
//  private $membro_id;
  private $tipo_bem_id;
  private $ativo;
  private $user_id;
  private $empresa_id;
  private $created;
  private $modified;

  /**
   * Bem constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL bem_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->nome = $l["nome"];
        $this->identificacao = $l["identificacao"];
        $this->num_serie = $l["num_serie"];
        $this->num_ativo = $l["num_ativo"];
        $this->marca = $l["marca"];
        $this->modelo = $l["modelo"];
        $this->descricao = $l["descricao"];
        $this->observacao = $l["observacao"];
        $this->data_compra = $l["data_compra"];
        $this->garantia = $l["garantia"];
        $this->valor_unitario = $l["valor_unitario"];
//        $this->quantidade = $l["quantidade"];
        $this->departamento_id = $l["departamento_id"];
        $this->local_id = $l["local_id"];
//        $this->membro_id = $l["membro_id"];
        $this->tipo_bem_id = $l["tipo_bem_id"];
        $this->ativo = $l["ativo"];
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
  public function getIdentificacao() {
    return $this->identificacao;
  }
  
  /**
   * @param mixed $identificacao
   */
  public function setIdentificacao($identificacao) {
    $this->identificacao = $identificacao;
  }

  /**
  * @return mixed
  */
  public function getNumSerie() {
    return $this->num_serie;
  }
  
  /**
   * @param mixed $num_serie
   */
  public function setNumSerie($num_serie) {
    $this->num_serie = $num_serie;
  }

  /**
  * @return mixed
  */
  public function getNumAtivo() {
    return $this->num_ativo;
  }
  
  /**
   * @param mixed $num_ativo
   */
  public function setNumAtivo($num_ativo) {
    $this->num_ativo = $num_ativo;
  }

  /**
  * @return mixed
  */
  public function getMarca() {
    return $this->marca;
  }
  
  /**
   * @param mixed $marca
   */
  public function setMarca($marca) {
    $this->marca = $marca;
  }

  /**
  * @return mixed
  */
  public function getModelo() {
    return $this->modelo;
  }
  
  /**
   * @param mixed $modelo
   */
  public function setModelo($modelo) {
    $this->modelo = $modelo;
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
  public function getObservacao() {
    return $this->observacao;
  }
  
  /**
   * @param mixed $observacao
   */
  public function setObservacao($observacao) {
    $this->observacao = $observacao;
  }

  /**
  * @return mixed
  */
  public function getDataCompra() {
    return \bd\Formatos::dataApp($this->data_compra);
  }
  
  /**
   * @param mixed $data_compra
   */
  public function setDataCompra($data_compra) {
    $this->data_compra = \bd\Formatos::dataBd($data_compra);
  }

  /**
  * @return mixed
  */
  public function getGarantia() {
    return \bd\Formatos::dataApp($this->garantia);
  }
  
  /**
   * @param mixed $garantia
   */
  public function setGarantia($garantia) {
    $this->garantia = \bd\Formatos::dataBd($garantia);
  }

  /**
  * @return mixed
  */
  public function getValorUnitario() {
    return \bd\Formatos::real($this->valor_unitario);
  }
  
  /**
   * @param mixed $valor_unitario
   */
  public function setValorUnitario($valor_unitario) {
    $this->valor_unitario = \bd\Formatos::real($valor_unitario);
  }

  /**
  * @return mixed
  */
//  public function getQuantidade() {
//    return \bd\Formatos::inteiro($this->quantidade);
//  }
  
  /**
   * @param mixed $quantidade
   */
//  public function setQuantidade($quantidade) {
//    $this->quantidade = \bd\Formatos::inteiro($quantidade);
//  }

  /**
  * @return mixed
  */
  public function getDepartamentoId() {
    return \bd\Formatos::inteiro($this->departamento_id);
  }
  
  /**
   * @param mixed $departamento_id
   */
  public function setDepartamentoId($departamento_id) {
    $this->departamento_id = \bd\Formatos::inteiro($departamento_id);
  }

  /**
  * @return mixed
  */
  public function getLocalId() {
    return \bd\Formatos::inteiro($this->local_id);
  }
  
  /**
   * @param mixed $local_id
   */
  public function setLocalId($local_id) {
    $this->local_id = \bd\Formatos::inteiro($local_id);
  }

  /**
  * @return mixed
  */
//  public function getMembroId() {
//    return \bd\Formatos::inteiro($this->membro_id);
//  }
  
  /**
   * @param mixed $membro_id
   */
//  public function setMembroId($membro_id) {
//    $this->membro_id = \bd\Formatos::inteiro($membro_id);
//  }

  /**
  * @return mixed
  */
  public function getTipoBemId() {
    return \bd\Formatos::inteiro($this->tipo_bem_id);
  }
  
  /**
   * @param mixed $tipo_bem_id
   */
  public function setTipoBemId($tipo_bem_id) {
    $this->tipo_bem_id = \bd\Formatos::inteiro($tipo_bem_id);
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
    if (!$this->nome) {
      throw new \Exception("Nome obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL bem_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "issssssssssiiiisiiss",
              $this->id,
              $this->nome,
              $this->identificacao,
              $this->num_serie,
              $this->num_ativo,
              $this->marca,
              $this->modelo,
              $this->descricao,
              $this->observacao,
              $this->data_compra,
              $this->garantia,
              $this->valor_unitario,
//              $this->quantidade,
              $this->departamento_id,
              $this->local_id,
//              $this->membro_id,
              $this->tipo_bem_id,
              $this->ativo,
              $this->user_id,
              $this->empresa_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL bem_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "ssssssssssiiiiiiss", 
              $this->nome,
              $this->identificacao,
              $this->num_serie,
              $this->num_ativo,
              $this->marca,
              $this->modelo,
              $this->descricao,
              $this->observacao,
              $this->data_compra,
              $this->garantia,
              $this->valor_unitario,
//              $this->quantidade,
              $this->departamento_id,
              $this->local_id,
//              $this->membro_id,
              $this->tipo_bem_id,
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

  public static function seleciona($ativo = null) {
    $c = My::con();
    if (is_null($ativo) || !isset($ativo) || $ativo == '') {
      $ativo = 'T';
    } 
    $r = $c->query("CALL bens_seleciona(".EMPRESA.",'".$ativo."')");
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }
}
?>