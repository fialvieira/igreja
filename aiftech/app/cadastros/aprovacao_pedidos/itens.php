<?php

use modelo\CompraOrcamento;
use templates\Igreja;

include "../../../def.php";
try {
    $compra = (isset($_GET["compra"]) && $_GET["compra"] != "") ? $_GET["compra"] : null;
    $dispositivo = (isset($_GET["dispositivo"]) && $_GET["dispositivo"] != "") ? $_GET["dispositivo"] : null;
    $situacao = (isset($_GET["situacao"]) && $_GET["situacao"] != "") ? $_GET["situacao"] : null;
    $retorno = CompraOrcamento::selecionaOrcamentos($compra, 'S');
    $disabled = ($situacao != 'S' && $situacao != '') ? 'disabled' : '';
    if (count($retorno) > 0) {
        include "itens.html.php";
    }
} catch (Exception $e) {
    Igreja::erro($e);
}