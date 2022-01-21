<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_BANCARIAS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\ContasFinanceira($id);
    $bancos = \modelo\Banco::seleciona();
    $filtro = explode(",", $id);
    include "contas_financeira.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}