<?php

include "../../../def.php";

use modelo\Ata;
use modelo\Empresa;
use modelo\Endereco;
use modelo\Membro;
use Mpdf\Mpdf;

require_once RAIZ . 'vendor/autoload.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['ATAS']);
    if (!isset($_GET['id']) OR $_GET['id'] == '') {
        $id = null;
    } else {
        $id = $_GET['id'];
    }

    $ata = new Ata($id);
////  $empresa = new Empresa(EMPRESA);
////  $endereco = new Endereco($empresa->getEndereco());
////  $presidente = new Membro($ata->getPresidencia());
////  $secretario = new Membro($ata->getSecretario());
//    $presidente = Membro::getCargosMembro($ata->getPresidencia(), substr($ata->getData(), 6, 4));
//    $secretario = Membro::getCargosMembro($ata->getSecretario(), substr($ata->getData(), 6, 4));
    $presidente = Membro::getCargoAtasByMembro('P', $ata->getPresidencia(), substr($ata->getData(), 6, 4));
    $secretario = Membro::getCargoAtasByMembro('S', $ata->getSecretario(), substr($ata->getData(), 6, 4));
    $cargos_secretario = Membro::getCargoSecretarioEmpresa();
    $presidente_nome = $presidente[0]['nome'];
    $presidente_cargo = ($presidente[0]['abreviacao'] != '') ? $presidente[0]['abreviacao'] : $presidente[0]['cargo'];
    $secretario_nome = $ata->getSecretarioNome();
    $secretario_cargo = 'Secretario(a) Ad hoc';
    if ($secretario) {
        foreach ($secretario as $s) {
            $secretario_nome = $s['nome'];
            if (array_search($s['cargo_id'], $cargos_secretario) !== false) {
                $secretario_cargo = $s['abreviacao'];
                break;
            }
        }
    }
//  setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
//  $data = convertNumToWords((int) substr($ata->getData(), 0, 2)) . ' de ' . mesPorExtenso($ata->getData()) .
//          ' de ' . convertNumToWords(substr($ata->getData(), 6, 4));

    $texto = $ata->getTxCorpo();
    $start = 0;

    ob_start();
    include 'imprime.html.php';
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
