<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['DONS']);
    if (Aut::temPermissao(Aut::$modulos['DONS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Dons.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}