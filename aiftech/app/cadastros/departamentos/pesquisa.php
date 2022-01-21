<?php

use modelo\Departamento;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['DEPARTAMENTOS']);
    if (Aut::temPermissao(Aut::$modulos['DEPARTAMENTOS'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Departamento::seleciona(null, null, null);
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}