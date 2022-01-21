<?php

use modelo\Local;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['LOCAIS']);
    
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new Local($codigo);
    $retorno->setEmpresasId(EMPRESA);
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