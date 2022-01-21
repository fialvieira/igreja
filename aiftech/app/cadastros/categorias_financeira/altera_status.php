<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANO_CONTAS'], \modelo\Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new CategoriasFinanceira($id);
    $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setModified($dh_atual);
    $retorno->alteraStatusAtivo();
    $ret = [
        "erro" => false,
        "mensagem" => 'Sucesso ao alterar status'
    ];
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()];
}
echo json_encode($ret);