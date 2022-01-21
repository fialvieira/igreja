<?php

use modelo\ContasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_BANCARIAS'], \modelo\Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $ativo = (isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null;
    $retorno = new ContasFinanceira($id);
    $retorno->setAtivo($ativo);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setModified($dh_atual);
    $retorno->alteraAtivo();
    $ret = [
        "erro" => false,
        "mensagem" => "Sucesso ao alterar status"
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()
    ];
    echo json_encode($ret);
}
