<?php

use modelo\RelatoriosMembros;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
require_once '../../../vendor/phpoffice/phpword/bootstrap.php';

try {
    Aut::filtraAutorizacao (Aut::$modulos['MEMBROS_AGENDA']);
    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale ($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }
    $status = (isset($_GET["status"]) && $_GET["status"] != "") ? $_GET["status"] : null;
    $quorum = (isset($_GET["quorum"]) && $_GET["quorum"] != "") ? $_GET["quorum"] : null;
    $local = (isset($_GET["local"]) && $_GET["local"] != "") ? $_GET["local"] : null;
    $local_atual = '';
    $letra_inicial = '';
    // Creating the new document...
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultParagraphStyle(
        array(
            'align'      => 'both',
            'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
            'spacing'    => 0,
        )
    );
    $retorno = RelatoriosMembros::membrosAgenda ($status, $quorum, $local);
    include 'membro.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro ($e);
}