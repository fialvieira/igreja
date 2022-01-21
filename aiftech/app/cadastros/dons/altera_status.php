<?php

use modelo\Dom;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['DONS'], \modelo\Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Dom($id);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->alteraStatusAtivo();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);