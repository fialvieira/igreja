<?php

use modelo\Orcamento;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new Orcamento($codigo);
    $filtro = explode(",", $codigo);
    
//    $categorias = \modelo\CategoriasFinanceira::selecionaTodos();
    $categorias = \modelo\CategoriasFinanceira::getCategoriasFilhas('S');
    $anos = Orcamento::getAnosAtivos();
    $year = date('Y');
    $meses = mesPorExtenso();
    
    include "planejamento_orcamentario.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}