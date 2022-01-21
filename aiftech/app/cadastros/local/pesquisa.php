<?php

use modelo\Local;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['LOCAIS']);
    if (Aut::temPermissao(Aut::$modulos['LOCAIS'], \modelo\Permissao::REWRITE)) {
        $retorno = Local::seleciona("T");
        $permitido = true;
    } else {
        $retorno = Local::seleciona();
        $permitido = false;
    }
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}