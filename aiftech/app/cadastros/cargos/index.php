<?php
include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CARGOS']);
    if (Aut::temPermissao(Aut::$modulos['CARGOS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ."docs/manuais/Cadastro_Cargos.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}