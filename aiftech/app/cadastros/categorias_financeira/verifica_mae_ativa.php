<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANO_CONTAS'], \modelo\Permissao::WRITE);
    $cat_mae_id = (isset($_GET["cat_mae_id"]) && $_GET["cat_mae_id"] != "") ? $_GET["cat_mae_id"] : null;
    $ativa = CategoriasFinanceira::verificaCategoriaAtiva($cat_mae_id);
    if ($ativa == 'S') {
        $retorno = true;
    } else {
        $retorno = false;
    }
    $ret = [
        "erro" => false,
        "mensagem" => 'Sucesso ao verificar dados',
        "ativa" => $retorno
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}