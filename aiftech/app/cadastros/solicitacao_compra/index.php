<?php

use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['SOLICITACAO_COMPRA']);
    if (Aut::temPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Aprovacao_pedido_compra.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    Igreja::erro($e);
}