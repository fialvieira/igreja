<?php

use modelo\TipoFornecedor;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['TIPO_FORNECEDORES']);
    if (Aut::temPermissao(Aut::$modulos['TIPO_FORNECEDORES'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        /*$retorno = TipoFornecedor::seleciona();*/
        $permitido = false;
    }
    $retorno = TipoFornecedor::seleciona('T');
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}