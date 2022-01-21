<?php
use modelo\RelatoriosMembros;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_GERAL']);
    $manual = '';
    include 'index.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}