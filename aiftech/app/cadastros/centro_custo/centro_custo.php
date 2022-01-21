<?php

use modelo\CentroCusto;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['CENTRO_DE_CUSTO'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new CentroCusto($codigo);
    $filtro = explode(",", $codigo);
    
    $principal = CentroCusto::getCentroPrincipal();

    $array = [
        'N' => 'Não',
        'S' => 'Sim'
    ];
    
    include "centro_custo.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}