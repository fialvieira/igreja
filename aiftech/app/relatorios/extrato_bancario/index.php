<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['EXTRATO_BANCARIO']);

    $bancos = modelo\Banco::seleciona();
    $contas = \modelo\ContasFinanceira::seleciona();
    $anos = MovimentacaoFinanceira::getAnosMovimentacao();
    $meses = mesPorExtenso();
    $mes_atual = date('m');
    krsort($meses);

    foreach ($anos as $ano) {
        foreach ($meses as $k => $v) {
            if ($k <= $mes_atual) {
                $periodos[] = [
                    'valor' => str_pad($k, 2, '0', STR_PAD_LEFT) . $ano['ANO'],
                    'descricao' => strtolower(substr($v, 0, 3)) . '/' . $ano['ANO']
                ];
            }
        }
    }

    $manual = ''; //RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";

    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}