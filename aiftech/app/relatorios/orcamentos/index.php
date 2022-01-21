<?php

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['ACOMPANHAMENTO_ORCAMENTO']);
    $manual = '';
    
    $anos = \modelo\Orcamento::getAnosAtivos();
    $year = date('Y');
    $meses = mesPorExtenso();
    
    include 'index.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}