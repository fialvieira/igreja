<?php

namespace modelo;

use bd\My;

class AtaArquivo {
  private $id;
  private $ata_id;
  private $nome;
  private $dataupload;
  private $user_id;
  private $empresa_id;
  private $created;
  private $modified;

  /**
   * AtaArquivo constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL ata_arquivo_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->ata_id = $l["ata_id"];
        $this->nome = $l["nome"];
        $this->dataupload = $l["dataupload"];
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
  public function getAtaId() {
    return \bd\Formatos::inteiro($this->ata_id);
  }
  
  /**
   * @param mixed $ata_id
   */
  public function setAtaId($ata_id) {
    $this->ata_id = \bd\Formatos::inteiro($ata_id);
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
  public function getDataupload() {
    return \bd\Formatos::dataApp($this->dataupload);
  }
  
  /**
   * @param mixed $dataupload
   */
  public function setDataupload($dataupload) {
    $this->dataupload = \bd\Formatos::dataBd($dataupload);
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
    if (!$this->ata_id) {
      throw new \Exception("Ata Id obrigatório(a).");
    }

    if (!$this->nome) {
      throw new \Exception("Nome obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL ata_arquivo_altera(?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "iissiiss",
              $this->id,
              $this->ata_id,
              $this->nome,
              $this->dataupload,
              $this->user_id,
              $this->empresa_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL ata_arquivo_insere(?,?,?,?,?,?,?)");
      $com->bind_param(
              "issiiss", 
              $this->ata_id,
              $this->nome,
              $this->dataupload,
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
      $r = $c->query("CALL ata_arquivos_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL ata_arquivos_fulltext_seleciona($valor,EMPRESA)");
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