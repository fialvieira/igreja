<?php

use modelo\CentroCusto;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CENTRO_DE_CUSTO']);
    if (Aut::temPermissao(Aut::$modulos['CENTRO_DE_CUSTO'], \modelo\Permissao::REWRITE)) {
        $retorno = CentroCusto::seleciona();
        $permitido = true;
    } else {
        $retorno = CentroCusto::seleciona('S');
        $permitido = false;
    }
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}