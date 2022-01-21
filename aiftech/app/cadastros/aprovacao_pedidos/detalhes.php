<?php

use modelo\CompraItem;
use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['APROVACAO_PEDIDOS']);
    $compra_id = ($_GET['compra_id'] == '' || is_null($_GET['compra_id']) || !isset($_GET['compra_id'])) ? null : $_GET['compra_id'];
    $retorno = CompraItem::seleciona($compra_id);
    
    include "detalhes.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}