<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['DEPARTAMENTOS']);
    if (Aut::temPermissao(Aut::$modulos['DEPARTAMENTOS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Departamentos.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}