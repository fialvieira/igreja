<?php

use modelo\Local;

include "../../../def.php";
try {
    if (Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN)) {
        $retorno = Local::seleciona("T");
//        $permitido = true;
    } else {
        $retorno = Local::seleciona();
//        $permitido = false;
    }
    if (Aut::temPermissao(Aut::$modulos['LOCAIS'], \modelo\Permissao::REWRITE)) {
        $edit = true;
    } else {
        $edit = false;
    }

    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}