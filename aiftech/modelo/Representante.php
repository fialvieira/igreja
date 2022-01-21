<?php

namespace modelo;

use bd\My;

class Representante {
  private $id;
  private $nome;
  private $email;
  private $idade;
  private $ddd;
  private $telefone;
  private $tipo_telefone;
  private $cidade;
  private $estado;
  private $classificacao;
  private $infoad;
  private $created;
  private $modified;

  /**
   * Representante constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL representante_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->nome = $l["nome"];
        $this->email = $l["email"];
        $this->idade = $l["idade"];
        $this->ddd = $l["ddd"];
        $this->telefone = $l["telefone"];
        $this->tipo_telefone = $l["tipo_telefone"];
        $this->cidade = $l["cidade"];
        $this->estado = $l["estado"];
        $this->classificacao = $l["classificacao"];
        $this->infoad = $l["infoad"];
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
  public function getIdade() {
    return \bd\Formatos::inteiro($this->idade);
  }
  
  /**
   * @param mixed $idade
   */
  public function setIdade($idade) {
    $this->idade = \bd\Formatos::inteiro($idade);
  }

  /**
  * @return mixed
  */
  public function getDdd() {
    return \bd\Formatos::inteiro($this->ddd);
  }
  
  /**
   * @param mixed $ddd
   */
  public function setDdd($ddd) {
    $this->ddd = \bd\Formatos::inteiro($ddd);
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
  public function getTipoTelefone() {
    return \bd\Formatos::inteiro($this->tipo_telefone);
  }
  
  /**
   * @param mixed $tipo_telefone
   */
  public function setTipoTelefone($tipo_telefone) {
    $this->tipo_telefone = \bd\Formatos::inteiro($tipo_telefone);
  }

  /**
  * @return mixed
  */
  public function getCidade() {
    return $this->cidade;
  }
  
  /**
   * @param mixed $cidade
   */
  public function setCidade($cidade) {
    $this->cidade = $cidade;
  }

  /**
  * @return mixed
  */
  public function getEstado() {
    return $this->estado;
  }
  
  /**
   * @param mixed $estado
   */
  public function setEstado($estado) {
    $this->estado = $estado;
  }

  /**
  * @return mixed
  */
  public function getClassificacao() {
    return \bd\Formatos::inteiro($this->classificacao);
  }
  
  /**
   * @param mixed $classificacao
   */
  public function setClassificacao($classificacao) {
    $this->classificacao = \bd\Formatos::inteiro($classificacao);
  }

  /**
  * @return mixed
  */
  public function getInfoad() {
    return $this->infoad;
  }
  
  /**
   * @param mixed $infoad
   */
  public function setInfoad($infoad) {
    $this->infoad = $infoad;
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

    if (!$this->email) {
      throw new \Exception("Email obrigatório(a).");
    }

    if (!$this->idade) {
      throw new \Exception("Idade obrigatório(a).");
    }

    if (!$this->ddd) {
      throw new \Exception("Ddd obrigatório(a).");
    }

    if (!$this->telefone) {
      throw new \Exception("Telefone obrigatório(a).");
    }

    if (!$this->tipo_telefone) {
      throw new \Exception("Tipo Telefone obrigatório(a).");
    }

    if (!$this->cidade) {
      throw new \Exception("Cidade obrigatório(a).");
    }

    if (!$this->estado) {
      throw new \Exception("Estado obrigatório(a).");
    }

    if (!$this->classificacao) {
      throw new \Exception("Classificacao obrigatório(a).");
    }

    if (!$this->infoad) {
      throw new \Exception("Infoad obrigatório(a).");
    }

    if (!$this->created) {
      throw new \Exception("Created obrigatório(a).");
    }

    if (!$this->modified) {
      throw new \Exception("Modified obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL representante_altera(?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "issiisississs",
              $this->id,
              $this->nome,
              $this->email,
              $this->idade,
              $this->ddd,
              $this->telefone,
              $this->tipo_telefone,
              $this->cidade,
              $this->estado,
              $this->classificacao,
              $this->infoad,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL representante_insere(?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "ssiisississs", 
              $this->nome,
              $this->email,
              $this->idade,
              $this->ddd,
              $this->telefone,
              $this->tipo_telefone,
              $this->cidade,
              $this->estado,
              $this->classificacao,
              $this->infoad,
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
      $r = $c->query("CALL representante_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL representante_fulltext_seleciona($valor,EMPRESA)");
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