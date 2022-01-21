<?php

use modelo\Banco;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['BANCOS']);
    if (isset($_GET["texto"]) && $_GET["texto"] != "") {
        $texto = $_GET["texto"];
    } else {
        $texto = null;
    }
    $retorno = Banco::seleciona($texto);
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}