<?php

use modelo\RelatoriosMembros;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_AGENDA']);
    $status = (isset($_GET["status"]) && $_GET["status"] != "") ? $_GET["status"] : null;
    $quorum = (isset($_GET["quorum"]) && $_GET["quorum"] != "") ? $_GET["quorum"] : null;
    $local = (isset($_GET["local"]) && $_GET["local"] != "") ? $_GET["local"] : null;
    $retorno = RelatoriosMembros::membrosAgenda($status, $quorum, $local);
    include 'pesquisa.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}