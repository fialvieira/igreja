<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['LOCAIS']);

    if (Aut::temPermissao(Aut::$modulos['LOCAIS'], \modelo\Permissao::WRITE)) {
        $new = true;
    } else {
        $new = false;
    }
    $manual = RAIZ."docs/manuais/Cadastro_Local.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}