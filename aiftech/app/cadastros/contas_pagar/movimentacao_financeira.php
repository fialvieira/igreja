<?php

use modelo\MovimentacaoFinanceira;
use modelo\ContasFinanceira;
use modelo\CategoriasFinanceira;
use modelo\Compra;
use modelo\MeioPagamento;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_PAGAR'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $compras = new Compra($codigo);
    $hoje = strtotime(date("Y-m-d"));
    $retorno = MovimentacaoFinanceira::listaMovimentacoesPorCompra($codigo, 'S', 'N');

    $oculto = '';
    if (count($retorno) === 0) {
        $oculto = 'oculto';
    }
    $contas = ContasFinanceira::seleciona();
    $categorias = CategoriasFinanceira::getCategoriasMae('S');
    $centros = modelo\CentroCusto::seleciona('S');
    $tipos = MovimentacaoFinanceira::TIPOS;
    $meios_pagamentos = MeioPagamento::MEIOS_PAGAMENTOS;
    $disabled = ($compras->getSituacao() === 'A') ? '' : 'disabled';
    include "movimentacao_financeira.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}