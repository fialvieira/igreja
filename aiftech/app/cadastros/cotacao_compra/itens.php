<?php

use modelo\CompraItem;

include "../../../def.php";
try {
    $compra = (isset($_GET["compra"]) && $_GET["compra"] != "") ? $_GET["compra"] : null;
    $situacao = (isset($_GET["situacao"]) && $_GET["situacao"] != "") ? $_GET["situacao"] : null;
    $retorno = CompraItem::seleciona($compra);

    $disabled = ($situacao != 'P' && $situacao != '') ? 'disabled' : '';

    if ($retorno) {
        include "itens.html.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}