<?php

use modelo\TipoFornecedor;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['TIPO_FORNECEDORES'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new TipoFornecedor($id);
    if (isset($_GET["descricao"]) && $_GET["descricao"]) {
        $retorno->setDescricao($_GET["descricao"]);
    }
    if (isset($_GET["ativo"]) && $_GET["ativo"]) {
        $retorno->setAtivo($_GET["ativo"]);
    }
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);