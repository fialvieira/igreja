<?php

use modelo\Produto;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PRODUTOS']);
    if (Aut::temPermissao(Aut::$modulos['PRODUTOS'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Produto::seleciona();
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}