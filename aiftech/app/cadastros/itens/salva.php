<?php
    use modelo\Item;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Item($id);
        $retorno->setIsbn((isset($_GET["isbn"]) && $_GET["isbn"] != "")? $_GET["isbn"] : null);
        $retorno->setTitulo((isset($_GET["titulo"]) && $_GET["titulo"] != "")? $_GET["titulo"] : null);
        $retorno->setFoto((isset($_GET["foto"]) && $_GET["foto"] != "")? $_GET["foto"] : null);
        $retorno->setPaginas((isset($_GET["paginas"]) && $_GET["paginas"] != "")? $_GET["paginas"] : null);
        $retorno->setPreco((isset($_GET["preco"]) && $_GET["preco"] != "")? $_GET["preco"] : null);
        $retorno->setComentarios((isset($_GET["comentarios"]) && $_GET["comentarios"] != "")? $_GET["comentarios"] : null);
        $retorno->setEstoque((isset($_GET["estoque"]) && $_GET["estoque"] != "")? $_GET["estoque"] : null);
        $retorno->setAutorId((isset($_GET["autor_id"]) && $_GET["autor_id"] != "")? $_GET["autor_id"] : null);
        $retorno->setCategoriaId((isset($_GET["categoria_id"]) && $_GET["categoria_id"] != "")? $_GET["categoria_id"] : null);
        $retorno->setEditoraId((isset($_GET["editora_id"]) && $_GET["editora_id"] != "")? $_GET["editora_id"] : null);
        $retorno->setTipoId((isset($_GET["tipo_id"]) && $_GET["tipo_id"] != "")? $_GET["tipo_id"] : null);
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>