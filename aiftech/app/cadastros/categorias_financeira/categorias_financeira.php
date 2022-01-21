<?php

use modelo\CategoriasFinanceira;
use modelo\ContasFinanceira;
use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANO_CONTAS']);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new CategoriasFinanceira($id);
    if (!is_null($id)) {
        $bancos = $retorno->getContasFinanceiras();
    }
    $filtro = explode(",", $id);
    $categorias_mae = CategoriasFinanceira::getCategoriasMae('S');
    $contas_financeiras = ContasFinanceira::seleciona();
    include "categorias_financeira.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}