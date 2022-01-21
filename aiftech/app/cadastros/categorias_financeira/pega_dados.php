<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANO_CONTAS']);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new CategoriasFinanceira($id);
    $ret = [
        'erro' => false,
        'tipo' => $retorno->getTipo()
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        'erro' => true,
        'mensagem' => $e->getMessage()
    ];
    echo json_encode($ret);
}