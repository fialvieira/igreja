<?php

use modelo\Empresa;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['IGREJAS']);
    if (Aut::temPermissao(Aut::$modulos['IGREJAS'], \modelo\Permissao::REWRITE)) {
        $retorno = Empresa::listaIgrejas();
        $permitido = true;
    } else {
        $retorno = Empresa::listaIgrejas();
        $permitido = false;
    }
    if (Aut::temPerfil(Aut::PERFIL_MASTER)) {
        $retorno = Empresa::listaIgrejas(NULL);
    }
    
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}