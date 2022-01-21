<?php

use modelo\Associacao;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['ASSOCIACOES'], \modelo\Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Associacao($id);
    $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setModified($dh_atual);
    $retorno->alteraStatusAtivo();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);