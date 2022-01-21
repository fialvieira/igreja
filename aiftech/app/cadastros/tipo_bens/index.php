<?php
include "../../../def.php";

try {
//    Aut::filtraAutorizacao(Aut::$modulos['TIPO_BENS']);
//    if (Aut::temPermissao(Aut::$modulos['TIPO_BENS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
//    } else {
//        $permitido = false;
//    }
    $manual = RAIZ."docs/manuais/Cadastro_Tipo_Bens.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
