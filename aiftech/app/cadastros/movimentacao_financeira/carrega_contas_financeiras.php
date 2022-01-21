<?php

use modelo\CategoriasFinanceira;
use modelo\ContasFinanceira;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;

    $contas_financ = new CategoriasFinanceira($id);

    $contas = $contas_financ->getContasFinanceiras();
    $todas = false;

    if (count($contas) <= 0) {
        $contas = ContasFinanceira::seleciona();
        $todas = true;
    }

    include "carrega_contas_financeiras.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}