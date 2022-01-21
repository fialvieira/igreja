<?php

use modelo\MovimentacaoSaldo;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['MOVIMENTACAO_SALDOS']);
    $retorno = MovimentacaoSaldo::seleciona(null, 'N');
    $tipo = MovimentacaoSaldo::TIPOS;
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}