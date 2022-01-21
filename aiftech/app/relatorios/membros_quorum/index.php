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
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_QUORUM']);
    $empresa = new Empresa(EMPRESA);
    $total_menores = Membro::getTotalMenoresAtivos('A', 'S');
    $endereco = new Endereco($empresa->getEndereco());
    $estado = new Estado($endereco->getEstado());
    $rel_membros = new RelatoriosMembros();
    $quorum_sede = $rel_membros->quorumSede();
    $nao_quorum_sede = $rel_membros->naoQuorumSede();
    $quorumNaoSede = $rel_membros->quorumForaDaSedeTotal(null);
    /*$naoQuorumNaoSede = $rel_membros->naoQuorumNaoSedeTotal(null);
    d($quorumNaoSede);*/
    ob_start();
    include 'quorum_assembleias.html.php';
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