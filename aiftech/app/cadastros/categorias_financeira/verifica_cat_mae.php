<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANO_CONTAS'], \modelo\Permissao::WRITE);
    $cat_mae_id = (isset($_GET["cat_mae_id"]) && $_GET["cat_mae_id"] != "") ? $_GET["cat_mae_id"] : null;
    $total_filhos = CategoriasFinanceira::verificaCategoriaMae($cat_mae_id);
    if ($total_filhos > 0) {
        $existe = true;
    } else {
        $existe = false;
    }
    $ret = [
        "erro" => false,
        "mensagem" => 'Sucesso ao verificar dados',
        "existe" => $existe
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}