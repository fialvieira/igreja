<?php

//use modelo\Empresa;
//use modelo\Endereco;
//use modelo\Estado;
use Mpdf\Mpdf;
use modelo\MovimentacaoSaldo;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['EXTRATO_BANCARIO']);

    $tipo = (isset($_GET['tipo']) && $_GET['tipo']) ? $_GET['tipo'] : null;
    $conta = (isset($_GET['conta']) && $_GET['conta']) ? $_GET['conta'] : null;
    $periodo = (isset($_GET['periodo']) && $_GET['periodo']) ? $_GET['periodo'] : null;
    if ($periodo == '000000') {
        $dt_ini = date('Y-m-d', strtotime('-30 days'));
        $dt_fim = date('Y-m-d');
    } else {
        $dt_ini = date('Y-m-d', strtotime(substr($periodo, 2, 4) . '-' . substr($periodo, 0, 2) . ' first day of this month'));
        $dt_fim = date('Y-m-d', strtotime(substr($periodo, 2, 4) . '-' . substr($periodo, 0, 2) . ' last day of this month'));
    }

    $retorno = MovimentacaoSaldo::extrato($conta, $dt_ini, $dt_fim);
    if ($tipo == 'P') {
        include "pesquisa.html.php";
    } else {
        if (!$retorno) {
            throw new Exception('Nenhum lançamento encontrado.');
        }
        $titulo = ($periodo == '000000') ? 'Últimos 30 dias' : mesPorExtenso(substr($periodo, 0, 2)) . '/' . substr($periodo, 2, 4);
        ob_start();
        include 'extrato.html.php';
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new Mpdf([
            'tempDir' => __DIR__ . '/temp',
            'setAutoTopMargin' => 'stretch',
            'autoMarginPadding' => 5
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}