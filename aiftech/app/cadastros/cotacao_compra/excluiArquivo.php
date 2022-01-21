<?php

use modelo\CompraOrcamento;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['COTACAO_COMPRA'], modelo\Permissao::WRITE);
    $dir = $_GET['dir'];
    $compra = $_GET['compra'];
    $id = (isset($_GET['id']) && $_GET['id'] != 'undefined') ? $_GET['id'] : NULL;

    if (file_exists($dir)) {
        if (!unlink($dir)) {
            throw \Exception('Erro Inesperado ao excluir o Arquivo');
        }
    }

    if (!is_null($id)) {
        $r = new CompraOrcamento($compra, $id);
        $r->excluiArquivo();
    }

    $ret = ["erro" => false];
    echo json_encode($ret);
} catch (\Exception $ex) {
    $ret = ["erro" => true, "mensagem" => $ex->getMessage()];
    echo json_encode($ret);
}