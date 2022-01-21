<?php

use modelo\ContasFinanceira;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CONTAS_BANCARIAS']);
    if (isset($_GET["texto"]) && $_GET["texto"] != "") {
        $texto = $_GET["texto"];
    } else {
        $texto = null;
    }
    $retorno = ContasFinanceira::seleciona($texto);

    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}