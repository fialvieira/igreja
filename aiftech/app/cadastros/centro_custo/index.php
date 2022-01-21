<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['CENTRO_DE_CUSTO']);
    if (Aut::temPermissao(Aut::$modulos['CENTRO_DE_CUSTO'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Centro_Custo.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}