<?php
use modelo\Local;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_AGENDA']);
    $locais = Local::getLocaisPorParametros('S', null, 'N');
    $manual = '';
    include 'index.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}