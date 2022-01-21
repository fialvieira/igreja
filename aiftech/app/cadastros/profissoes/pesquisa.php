<?php

use modelo\Profissao;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PROFISSOES']);
    if (isset($_GET["texto"]) && $_GET["texto"] != "") {
        $texto = $_GET["texto"];
    } else {
        $texto = null;
    }
    $retorno = Profissao::seleciona(null);
    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}