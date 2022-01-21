<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['TIPO_PRODUTOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\TipoProduto($id);
    $filtro = explode(",", $id);
    include "tipo_produto.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}