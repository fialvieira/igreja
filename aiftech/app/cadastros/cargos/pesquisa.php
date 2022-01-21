<?php

use modelo\Cargo;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CARGOS']);
    if (Aut::temPermissao(Aut::$modulos['CARGOS'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Cargo::seleciona('T');
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}