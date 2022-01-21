<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['ASSOCIACOES']);
    if (Aut::temPermissao(Aut::$modulos['ASSOCIACOES'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Associações.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}