<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PASTORES']);
    if (Aut::temPermissao(Aut::$modulos['PASTORES'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Modulo_Cadastro_de_Pastor.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}