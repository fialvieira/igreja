<?php

use modelo\MovimentacaoFinanceira;
use modelo\ContasFinanceira;
use modelo\CategoriasFinanceira;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new MovimentacaoFinanceira($codigo);
    $filtro = explode(",", $codigo);
    
    $contas = ContasFinanceira::seleciona();
   /* $categorias = \modelo\CategoriasFinanceira::getCategoriasFilhas('S');*/
    $categorias = CategoriasFinanceira::getCategoriasMae('S');
    $centros = modelo\CentroCusto::seleciona('S');
    $tipos = MovimentacaoFinanceira::TIPOS;
    $arquivos = [];
    if (!is_null($retorno->getId())) {
        $arquivos = modelo\Ata::selecionaArquivos($id);
    }
    
    $membros = modelo\Membro::seleciona(null,'S');
    $arrMembroCargos = [];
    foreach ($membros as $membro) {
        $arrMembroCargos[$membro['id']] [] = [
            'id' => $membro['id'],
            'nome' => $membro['nome']
        ];
    }
    
    include "movimentacao_financeira.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}