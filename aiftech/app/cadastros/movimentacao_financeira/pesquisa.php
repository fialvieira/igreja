<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['LANCAMENTOS_DIARIOS']);
    $retorno = MovimentacaoFinanceira::seleciona(null,'N');
    $tipo = MovimentacaoFinanceira::TIPOS;
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}