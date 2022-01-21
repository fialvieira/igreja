<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['FORNECEDORES'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Fornecedor($id);
    $estados = \modelo\Estado::seleciona();
    $tipos = \modelo\TipoFornecedor::seleciona();
    $filtro = explode(",", $id);
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Pastor.pdf";
    if ($retorno->getEnderecosId() != '') {
        $end = new \modelo\Endereco($retorno->getEnderecosId());
        $end_flag = true;
    } else {
        $end_flag = false;
    }
    include "fornecedor.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}