<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['TIPO_FORNECEDORES'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\TipoFornecedor($id);
    $filtro = explode(",", $id);
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Pastor.pdf";
    include "tipo_fornecedor.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}