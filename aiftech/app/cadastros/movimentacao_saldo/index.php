<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MOVIMENTACAO_SALDOS']);
    if (Aut::temPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Movimentacao_Financeira.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}