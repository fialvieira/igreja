<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], modelo\Permissao::WRITE);
    $dir = $_GET['dir'];
    $movimentacao_financeira = $_GET['movimentacao_financeira'];
    $id = (isset($_GET['id']) && $_GET['id'] != 'undefined') ? $_GET['id'] : NULL;

    if (!unlink($dir)) {
        throw \Exception('Erro Inesperado ao excluir o Arquivo');
    }
    if (!is_null($id)) {
        $r = new MovimentacaoFinanceira($movimentacao_financeira);
        $r->excluiArquivo($id);
    }
    $ret = ["erro" => false];
} catch (\Exception $ex) {
    $ret = ["erro" => true, "mensagem" => $ex->getMessage()];
}
echo json_encode($ret);
