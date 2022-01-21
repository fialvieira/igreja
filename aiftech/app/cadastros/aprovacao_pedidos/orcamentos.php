<?php

use modelo\CompraOrcamento;
use templates\Igreja;

include "../../../def.php";
try {
    $compra = (isset($_GET["compra"]) && $_GET["compra"] != "") ? $_GET["compra"] : null;
    $dispositivo = (isset($_GET["dispositivo"]) && $_GET["dispositivo"] != "") ? $_GET["dispositivo"] : null;
    $situacao = (isset($_GET["situacao"]) && $_GET["situacao"] != "") ? $_GET["situacao"] : null;
    $retorno = CompraOrcamento::selecionaOrcamentos($compra, 'N');
    if (count($retorno) > 0) {
        $tipo = [
            'S' => 'Selecionado',
            'N' => ''
        ];
        include "orcamentos.html.php";
    }
} catch (Exception $e) {
    Igreja::erro($e);
}