<?php

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
require_once '../../../vendor/phpoffice/phpword/bootstrap.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['IGREJAS_AGENDA']);
    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }
    $status = (isset($_GET["status"]) && $_GET["status"] != "") ? $_GET["status"] : null;
    $associacao = (isset($_GET["associacao"]) && $_GET["associacao"] != "") ? $_GET["associacao"] : null;
    $associacao_atual = '';
//    $letra_inicial = '';
    $cidade_atual = '';
    // Creating the new document...
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultParagraphStyle(
            array(
                'align' => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
                'spacing' => 0,
            )
    );
    $retorno = modelo\Empresa::igrejasAgenda($status, $associacao);
    include 'igreja.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}