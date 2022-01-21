<?php

use modelo\Pastor;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PASTORES']);
    if (Aut::temPermissao(Aut::$modulos['PASTORES'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Pastor::seleciona();
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}