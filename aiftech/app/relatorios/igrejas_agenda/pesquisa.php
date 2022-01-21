<?php

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['IGREJAS_AGENDA']);
    $status = (isset($_GET["status"]) && $_GET["status"] != "") ? $_GET["status"] : null;
    $associacao = (isset($_GET["associacao"]) && $_GET["associacao"] != "") ? $_GET["associacao"] : null;
    $retorno = modelo\Empresa::igrejasAgenda($status, $associacao);
    include 'pesquisa.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}