<?php

use modelo\Associacao;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['ASSOCIACOES']);
    if (Aut::temPermissao(Aut::$modulos['ASSOCIACOES'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $retorno = Associacao::seleciona();
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}