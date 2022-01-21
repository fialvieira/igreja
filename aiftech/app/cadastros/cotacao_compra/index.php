<?php

use templates\Igreja;
use modelo\Compra;
use modelo\Permissao;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['COTACAO_COMPRA']);
    if (Aut::temPermissao(Aut::$modulos['COTACAO_COMPRA'], Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cotacao_compra.pdf";
    $solicitantes = Compra::listaSolicitantes();

    include "index.html.php";
} catch (\Exception $e) {
    Igreja::erro($e);
}