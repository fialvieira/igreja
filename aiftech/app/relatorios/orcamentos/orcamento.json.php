<?php

use modelo\Orcamento;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['ACOMPANHAMENTO_ORCAMENTO']);
    $ano = ((isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : null);
    $mes = ((isset($_GET["mes"]) && $_GET["mes"] != "") ? $_GET["mes"] : null);

    $retorno = Orcamento::listaAcompanhamentoOrcamento($ano, $mes);
    if (!$retorno) {
        $msg = 'Não existe planejamento para o ';
        $msg .= (!is_null($mes)) ? 'mês de ' . mesPorExtenso($mes) . ' do ano de ' . $ano : 'ano de ' . $ano;
        throw new Exception($msg);
    }

    $total_receitas = 0;
    $total_despesas = 0;

    foreach ($retorno as $v) {
        if ($v['tipo'] == 'Receitas') {
            if ($v['flag_mae'] == 'S') {
                $total_receitas += $v['valor_realizado'];
            }
        } else {
            if ($v['flag_mae'] == 'S') {
                $total_despesas += $v['valor_realizado'];
            }
        }
    }

    $dados = [
        'Receitas' => $total_receitas,
        'Despesas' => $total_despesas,
        'mes' => $mes,
        'ano' => $ano
    ];

    echo json_encode([
        'erro' => false,
        'msg' => 'Sucesso',
        'dados' => $dados
    ]);
} catch (\Exception $e) {
    echo json_encode([
        'erro' => true,
        'msg' => $e->getMessage()
    ]);
}