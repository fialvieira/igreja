<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['RELATORIO_CONSELHO_DIRETOR']);
    $ano = (isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : null;
    if (is_null($ano)) {
        throw new \Exception('O campo ano não pode estar em branco');
    }
    $meses = MovimentacaoFinanceira::getMesesMovimentacaoPorAno($ano);
    include 'carrega_meses.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}