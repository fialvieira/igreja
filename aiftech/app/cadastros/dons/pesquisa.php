<?php

use modelo\Dom;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['DONS']);
    if(Aut::temPermissao(Aut::$modulos['DONS'], \modelo\Permissao::REWRITE)){
        $permitido = true;
    }else{
        $permitido = false;
    }
    $retorno = Dom::seleciona(null);
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}