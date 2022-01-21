<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['IGREJAS_AGENDA']);
    $associacoes = modelo\Associacao::seleciona('S');
    $manual = '';
    include 'index.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}