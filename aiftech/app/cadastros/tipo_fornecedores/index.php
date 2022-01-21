<?php
include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['TIPO_FORNECEDORES']);
    if (Aut::temPermissao(Aut::$modulos['TIPO_FORNECEDORES'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ."docs/manuais/Cadastro_Tipo_Fornecedores.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}