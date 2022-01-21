<?php

use modelo\Orcamento;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO']);
//    if (Aut::temPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::REWRITE)) {
//        $retorno = MovimentacaoFinanceira::seleciona();
//        $permitido = true;
//    } else {
//        $retorno = MovimentacaoFinanceira::seleciona();
//        $permitido = false;
//    }
    $ano = (isset($_GET['ano']) && $_GET['ano']) ? $_GET['ano'] : null;
    $mes = (isset($_GET['mes']) && $_GET['mes']) ? $_GET['mes'] : null;
    $retorno = Orcamento::seleciona($ano, $mes);

    $year = date('Y');
    $month = date('m');

    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}