<?php

use modelo\Empresa;
use modelo\Endereco;
use modelo\Estado;
use modelo\RelatoriosCaixa;
use modelo\CategoriasFinanceira;
use Mpdf\Mpdf;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['RELATORIO_CONSELHO_DIRETOR']);
    $ano = (isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : null;
    $mes = (isset($_GET["mes"]) && $_GET["mes"] != "") ? $_GET["mes"] : null;
    $movimentacao = (isset($_GET["movimentacao"]) && $_GET["movimentacao"] != "") ? $_GET["movimentacao"] : null;
    $tipo = (isset($_GET["tipo"]) && $_GET["tipo"] != "") ? $_GET["tipo"] : null;
    if (is_null($ano)) {
        throw new \Exception('O campo ano não pode estar em branco');
    }
    if (is_null($mes)) {
        throw new \Exception('O campo mês não pode estar em branco');
    }
    /*if (is_null($movimentacao)) {
        throw new \Exception('O campo movimentação não pode estar em branco');
    }*/
    if (is_null($tipo)) {
        throw new \Exception('O campo tipo não pode estar em branco');
    }

    $empresa = new Empresa(EMPRESA);
    $endereco = new Endereco($empresa->getEndereco());
    $estado = new Estado($endereco->getEstado());

    $caixa = new RelatoriosCaixa($ano, $mes);
    $caixa->setCancelado('N');
    $mes_por_extenso = mesPorExtenso($mes);

    $raizes = CategoriasFinanceira::categoriasRaizes();

    /*if(!is_null($movimentacao)){
        $caixa->setTipo($movimentacao);
        $mf_cat = $caixa->caixaGeralPorCategoriaMae();
    }else{
        $caixa->setTipo('E');
        $mfe_cat = $caixa->caixaGeralPorCategoriaMae();
        $caixa->setTipo('S');
        $mfs_cat = $caixa->caixaGeralPorCategoriaMae();
    }


    $receita_anterior = \modelo\MovimentacaoFinanceira::getMovimentoAnterior($ano, $mes, 'E');
    $despesa_anterior = \modelo\MovimentacaoFinanceira::getMovimentoAnterior($ano, $mes, 'S');
    $saldo_anterior = $receita_anterior - $despesa_anterior;

    $receita_atual = \modelo\MovimentacaoFinanceira::getMovimentoAtual($ano, $mes, 'E');
    $despesa_atual = \modelo\MovimentacaoFinanceira::getMovimentoAtual($ano, $mes, 'S');
    $saldo_atual = $receita_atual - $despesa_atual;

    $saldo_final = $saldo_anterior + $saldo_atual;

    $saldo_caixa = \modelo\MovimentacaoSaldo::getSaldosPorTipo('V');
    $saldo_aplicacao = \modelo\MovimentacaoSaldo::getSaldosPorTipo('A');
    $saldo_cc = \modelo\MovimentacaoSaldo::getSaldosPorTipo('C');

    $aplicacoes = \modelo\MovimentacaoSaldo::getTotaisSaldosProvisaoResgate('A', 'E');
    $resgates = \modelo\MovimentacaoSaldo::getTotaisSaldosProvisaoResgate('A', 'S');

    $apuracao_sub_total = (floatval($saldo_anterior) + floatval($receita_atual) + floatval($resgates)) - (floatval($despesa_atual) + floatval($aplicacoes));*/

    if (is_null($movimentacao) && $tipo == 'A') {
        ob_start();
        include 'caixa_analitico.html.php';
    }

    if (is_null($movimentacao) && $tipo == 'S') {
        ob_start();
        include 'caixa_sintetico.html.php';
    }

   /* if ($movimentacao == 'E' && $tipo == 'A') {
        ob_start();
        include 'caixa_entrada_analitico.html.php';
    }

    if ($movimentacao == 'S' && $tipo == 'A') {
        ob_start();
        include 'caixa_saida_analitico.html.php';
    }

    if ($movimentacao == 'E' && $tipo == 'S') {
        ob_start();
        include 'caixa_entrada_sintetico.html.php';
    }

    if ($movimentacao == 'S' && $tipo == 'S') {
        ob_start();
        include 'caixa_saida_sintetico.html.php';
    }*/

    $html = ob_get_contents();
    ob_end_clean();
    $mpdf = new Mpdf([
        'tempDir' => __DIR__ . '/temp',
        'setAutoTopMargin' => 'stretch',
        'autoMarginPadding' => 5
    ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}