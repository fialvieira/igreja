<?php

use modelo\RelatoriosMembros;
use modelo\Empresa;
use modelo\Endereco;
use modelo\Estado;
use Mpdf\Mpdf;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';

try {
    Aut::filtraAutorizacao (Aut::$modulos['MEMBROS_AGENDA_ENDERECOS']);
    $status = (isset($_GET["status"]) && $_GET["status"] != "") ? $_GET["status"] : null;
    $quorum = (isset($_GET["quorum"]) && $_GET["quorum"] != "") ? $_GET["quorum"] : null;
    $flag_endereco = (isset($_GET["endereco"]) && $_GET["endereco"] != "") ? $_GET["endereco"] : null;

    $empresa = new Empresa(EMPRESA);
    $endereco = new Endereco($empresa->getEndereco());
    $estado = new Estado($endereco->getEstado());

    $letra_inicial = '';
    $end = 'x99';
    $num = 'x99';
    $com = 'x99';

    $retorno = RelatoriosMembros::membrosAgendaEnderecos ($status, $quorum, $flag_endereco);

    ob_start ();
    include 'membro.html.php';
    $html = ob_get_contents ();
    ob_end_clean ();
    $mpdf = new Mpdf([
        'tempDir' => __DIR__ . '/temp',
        'setAutoTopMargin' => 'stretch',
        'autoMarginPadding' => 5
    ]);
    $mpdf->WriteHTML ($html);
    $mpdf->Output ();
} catch (\Exception $e) {
    \templates\Igreja::erro ($e);
}