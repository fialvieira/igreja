<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['RELATORIO_CONSELHO_DIRETOR']);
    $anos = MovimentacaoFinanceira::getAnosMovimentacao();
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}