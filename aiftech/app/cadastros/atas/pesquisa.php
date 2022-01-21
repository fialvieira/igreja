<?php

use modelo\Ata;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['ATAS']);
    if (Aut::temPermissao(Aut::$modulos['ATAS'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Ata::seleciona(null, 100);


    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>