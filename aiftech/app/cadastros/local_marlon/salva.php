<?php

use modelo\Local;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['LOCAIS'], \modelo\Permissao::WRITE);
    
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new Local($codigo);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setSede((isset($_GET["sede"]) && $_GET["sede"] != "") ? $_GET["sede"] : null);
    $retorno->setEmpresasId(EMPRESA);
    $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);