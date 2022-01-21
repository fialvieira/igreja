<?php

use modelo\Permissao;
use templates\Igreja;
use modelo\Compra;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CONTAS_PAGAR']);
    if (Aut::temPermissao(Aut::$modulos['CONTAS_PAGAR'], Permissao::WRITE)) {
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