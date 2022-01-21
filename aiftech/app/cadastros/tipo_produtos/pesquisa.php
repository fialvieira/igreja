<?php

use modelo\TipoProduto;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['TIPO_PRODUTOS']);
    if(Aut::temPermissao(Aut::$modulos['TIPO_PRODUTOS'], \modelo\Permissao::REWRITE)){
        $permitido = true;
    }else{
        $permitido = false;
    }
    $retorno = TipoProduto::seleciona();
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}