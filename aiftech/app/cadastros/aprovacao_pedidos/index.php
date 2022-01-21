<?php

use modelo\Permissao;
use templates\Igreja;
use modelo\Compra;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['APROVACAO_PEDIDOS']);
    if (Aut::temPermissao(Aut::$modulos['APROVACAO_PEDIDOS'], Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $solicitantes = Compra::listaSolicitantes();
    $manual = '';
    include "index.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}