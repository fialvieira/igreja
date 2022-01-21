<?php

use modelo\Empresa;
use modelo\Endereco;
use modelo\Estado;
use modelo\RelatoriosMembros;
use Mpdf\Mpdf;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
require_once '../../../vendor/phpoffice/phpword/bootstrap.php';

try {
    /*Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_ANIVERSARIO_DE_CASAMENTO']);*/
    $mes = (isset($_GET["mes"]) && $_GET["mes"] != "") ? $_GET["mes"] : null;
    $dh_atual = date("Y-m-d H:i:s");
    /*if (is_null($mes)) {
        throw new \Exception('O campo mês não pode estar em branco');
    }*/
    $empresa = new Empresa(EMPRESA);
    $endereco = new Endereco($empresa->getEndereco());
    $estado = new Estado($endereco->getEstado());
    $aniversariantes = RelatoriosMembros::bodas($mes);
    $mes_atual = '';
    if (!is_null($mes)) {
        ob_start();
        include 'matrimonios.html.php';
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new Mpdf([
            'tempDir' => __DIR__ . '/temp',
            'setAutoTopMargin' => 'stretch',
            'autoMarginPadding' => 5
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    } else {
        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultParagraphStyle(
            array(
                'align' => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
                'spacing' => 0,
            )
        );
        include 'matrimonios_geral.html.php';
    }

} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}