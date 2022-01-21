<?php

use modelo\CompraOrcamento;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['CONTAS_PAGAR']);
    $compra_id = (isset($_GET["compra_id"]) && $_GET["compra_id"] != "") ? $_GET["compra_id"] : null;
    $retorno = CompraOrcamento::selecionaOrcamentos($compra_id, 'S', 'A');
    $tipo = [
        'S' => 'Selecionado',
        'N' => ''
    ];

    if ($retorno) {
        include "arquivos.html.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}