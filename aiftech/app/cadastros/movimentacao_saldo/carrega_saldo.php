<?php

use modelo\MovimentacaoSaldo;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'], \modelo\Permissao::WRITE);
    $conta_id = (isset($_GET["conta_id"]) && $_GET["conta_id"] != "") ? $_GET["conta_id"] : null;
    $res = MovimentacaoSaldo::getUltimoIdPorContaFinanceira($conta_id);
    if ($res == '' || is_null($res) || !isset($res)) {
        $res = MovimentacaoSaldo::getSaldoInicial($conta_id);
    }
    $ret = [
        'erro' => false,
        'mensagem' => 'Sucesso ao retornar saldo',
        'saldo' => $res['saldo']
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        'erro' => true,
        'mensagem' => 'Erro ao retornar saldo'
    ];
    echo json_encode($ret);
}