<?php

use modelo\MovimentacaoFinanceira;
use modelo\Compra;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_PAGAR'], modelo\Permissao::WRITE);

    $tipo = (isset($_GET['tipo']) && $_GET['tipo'] != 'undefined') ? $_GET['tipo'] : NULL;

    if ($tipo == 'ctn_arquivos_notas') {
        $dir = $_GET['dir'];
        $codigo = $_GET['codigo'];
        if (!unlink($dir)) {
            throw \Exception('Erro Inesperado ao excluir o Arquivo');
        }
        $r = new Compra($codigo);
        $r->excluiArquivoNota();
    } else {
        $codigo = $_POST['codigo'];
        $r = new MovimentacaoFinanceira($codigo);
        $arquivo = MovimentacaoFinanceira::selecionaArquivos($codigo, null);
        $id = $arquivo[0]['id'];
        $dir = $arquivo[0]['path'];
        if ($id != '' && $dir != '') {
            if (!unlink($dir)) {
                throw \Exception('Erro Inesperado ao excluir o Arquivo');
            }
            $r->excluiArquivo($id);
        }
    }
    $ret = ["erro" => false];
    echo json_encode($ret);
} catch (\Exception $ex) {
    $ret = ["erro" => true, "mensagem" => $ex->getMessage()];
    echo json_encode($ret);
}