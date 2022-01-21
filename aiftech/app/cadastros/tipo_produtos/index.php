<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['TIPO_PRODUTOS']);
    if (Aut::temPermissao(Aut::$modulos['TIPO_PRODUTOS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = '';
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}