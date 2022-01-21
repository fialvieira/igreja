<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANO_CONTAS']);
    if (isset($_GET["texto"]) && $_GET["texto"] != "") {
        $texto = $_GET["texto"];
    } else {
        $texto = null;
    }
    $retorno = CategoriasFinanceira::selecionaTodos();
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}