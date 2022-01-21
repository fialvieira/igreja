<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['LANCAMENTOS_DIARIOS']);
    if (Aut::temPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Movimentacao_Financeira.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}