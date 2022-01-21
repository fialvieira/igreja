<?php

use modelo\Produto;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['PRODUTOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Produto($id);
    $filtro = explode(",", $id);
    $tipo_produtos = \modelo\TipoProduto::seleciona();
    $fornecedores = \modelo\Fornecedor::seleciona('S');
    if(!is_null($id)){
        $fornecedores_produto = Produto::selecionaFornecedoresAtivos($id);
    }
    include "produto.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}