<?php

namespace modelo;

use bd\My;

class Item {
  private $id;
  private $isbn;
  private $titulo;
  private $foto;
  private $paginas;
  private $preco;
  private $comentarios;
  private $estoque;
  private $autor_id;
  private $categoria_id;
  private $editora_id;
  private $tipo_id;
  private $empresa_id;
  private $user_id;
  private $created;
  private $modified;

  /**
   * Item constructor. 
   * @param $id  
   * @throws \Exception
   */
  public function __construct($id = null) {
    if (!is_null($id)) {
      $id = \bd\Formatos::inteiro($id);
      $c = My::con();
      $r = $c->query("CALL item_seleciona($id)");
      $l = $r->fetch_assoc();
      if ($l) { 
        $this->id = $id;
        $this->isbn = $l["isbn"];
        $this->titulo = $l["titulo"];
        $this->foto = $l["foto"];
        $this->paginas = $l["paginas"];
        $this->preco = $l["preco"];
        $this->comentarios = $l["comentarios"];
        $this->estoque = $l["estoque"];
        $this->autor_id = $l["autor_id"];
        $this->categoria_id = $l["categoria_id"];
        $this->editora_id = $l["editora_id"];
        $this->tipo_id = $l["tipo_id"];
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
  public function getIsbn() {
    return $this->isbn;
  }
  
  /**
   * @param mixed $isbn
   */
  public function setIsbn($isbn) {
    $this->isbn = $isbn;
  }

  /**
  * @return mixed
  */
  public function getTitulo() {
    return $this->titulo;
  }
  
  /**
   * @param mixed $titulo
   */
  public function setTitulo($titulo) {
    $this->titulo = $titulo;
  }

  /**
  * @return mixed
  */
  public function getFoto() {
    return $this->foto;
  }
  
  /**
   * @param mixed $foto
   */
  public function setFoto($foto) {
    $this->foto = $foto;
  }

  /**
  * @return mixed
  */
  public function getPaginas() {
    return \bd\Formatos::inteiro($this->paginas);
  }
  
  /**
   * @param mixed $paginas
   */
  public function setPaginas($paginas) {
    $this->paginas = \bd\Formatos::inteiro($paginas);
  }

  /**
  * @return mixed
  */
  public function getPreco() {
    return \bd\Formatos::real($this->preco);
  }
  
  /**
   * @param mixed $preco
   */
  public function setPreco($preco) {
    $this->preco = \bd\Formatos::real($preco);
  }

  /**
  * @return mixed
  */
  public function getComentarios() {
    return $this->comentarios;
  }
  
  /**
   * @param mixed $comentarios
   */
  public function setComentarios($comentarios) {
    $this->comentarios = $comentarios;
  }

  /**
  * @return mixed
  */
  public function getEstoque() {
    return \bd\Formatos::inteiro($this->estoque);
  }
  
  /**
   * @param mixed $estoque
   */
  public function setEstoque($estoque) {
    $this->estoque = \bd\Formatos::inteiro($estoque);
  }

  /**
  * @return mixed
  */
  public function getAutorId() {
    return \bd\Formatos::inteiro($this->autor_id);
  }
  
  /**
   * @param mixed $autor_id
   */
  public function setAutorId($autor_id) {
    $this->autor_id = \bd\Formatos::inteiro($autor_id);
  }

  /**
  * @return mixed
  */
  public function getCategoriaId() {
    return \bd\Formatos::inteiro($this->categoria_id);
  }
  
  /**
   * @param mixed $categoria_id
   */
  public function setCategoriaId($categoria_id) {
    $this->categoria_id = \bd\Formatos::inteiro($categoria_id);
  }

  /**
  * @return mixed
  */
  public function getEditoraId() {
    return \bd\Formatos::inteiro($this->editora_id);
  }
  
  /**
   * @param mixed $editora_id
   */
  public function setEditoraId($editora_id) {
    $this->editora_id = \bd\Formatos::inteiro($editora_id);
  }

  /**
  * @return mixed
  */
  public function getTipoId() {
    return \bd\Formatos::inteiro($this->tipo_id);
  }
  
  /**
   * @param mixed $tipo_id
   */
  public function setTipoId($tipo_id) {
    $this->tipo_id = \bd\Formatos::inteiro($tipo_id);
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
    if (!$this->titulo) {
      throw new \Exception("Titulo obrigatório(a).");
    }

    if ($this->id) {
      $com = $c->prepare("CALL item_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "isssidsiiiiiiiss",
              $this->id,
              $this->isbn,
              $this->titulo,
              $this->foto,
              $this->paginas,
              $this->preco,
              $this->comentarios,
              $this->estoque,
              $this->autor_id,
              $this->categoria_id,
              $this->editora_id,
              $this->tipo_id,
              $this->empresa_id,
              $this->user_id,
              $this->created,
              $this->modified
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL item_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $com->bind_param(
              "sssidsiiiiiiiss", 
              $this->isbn,
              $this->titulo,
              $this->foto,
              $this->paginas,
              $this->preco,
              $this->comentarios,
              $this->estoque,
              $this->autor_id,
              $this->categoria_id,
              $this->editora_id,
              $this->tipo_id,
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
      $r = $c->query("CALL itens_seleciona(EMPRESA)");
    }else{
      $r = $c->query("CALL itens_fulltext_seleciona($valor,EMPRESA)");
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