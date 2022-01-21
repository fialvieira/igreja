<?php

use modelo\Membro;
use modelo\Empresa;
use modelo\Endereco;
use modelo\Estado;
use modelo\RelatoriosMembros;
use Mpdf\Mpdf;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_MENORES_DE_18_ANOS']);
    $empresa = new Empresa(EMPRESA);
    $ativo = (isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null;
    $quorum = (isset($_GET["quorum"]) && $_GET["quorum"] != "") ? $_GET["quorum"] : null;
    $menores = Membro::getMenoresIdade($ativo, $quorum);
    $total_menores = Membro::getTotalMenoresAtivos($ativo, $quorum);
    $endereco = new Endereco($empresa->getEndereco());
    $estado = new Estado($endereco->getEstado());
    $rel_membros = new RelatoriosMembros();
    ob_start();
    include 'membros_menores.html.php';
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf = new Mpdf(['tempDir' => __DIR__ . '/temp',
                      'setAutoTopMargin' => 'stretch',
                      'autoMarginPadding' => 5
                    ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}