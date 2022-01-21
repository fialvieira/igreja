<?php

use modelo\Dom;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['DONS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Dom($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setObservacoes((isset($_GET["observacoes"]) && $_GET["observacoes"] != "") ? $_GET["observacoes"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);