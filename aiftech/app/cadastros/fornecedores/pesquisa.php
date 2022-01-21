<?php

use modelo\Fornecedor;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['FORNECEDORES']);
    if (Aut::temPermissao(Aut::$modulos['FORNECEDORES'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Fornecedor::seleciona('T');
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}