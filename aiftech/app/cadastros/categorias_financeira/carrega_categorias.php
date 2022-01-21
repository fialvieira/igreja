<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANO_CONTAS']);
    $categorias_mae = CategoriasFinanceira::getCategoriasMae();
    include "carrega_categorias.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}