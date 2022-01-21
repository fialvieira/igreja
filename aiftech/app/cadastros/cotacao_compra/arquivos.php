<?php

use modelo\CompraOrcamento;

include "../../../def.php";
try {
    $compra_id = (isset($_GET["compra_id"]) && $_GET["compra_id"] != "") ? $_GET["compra_id"] : null;
    $retorno = CompraOrcamento::seleciona($compra_id);

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
?>