<?php

require_once '../../vendor/phpoffice/phpword/bootstrap.php';

use PhpOffice\PhpWord\Settings;

date_default_timezone_set('UTC');
error_reporting(E_ALL);
Settings::loadConfig();
$dompdfPath = $vendorDirPath . '/dompdf/dompdf';
if (file_exists($dompdfPath)) {
    define('DOMPDF_ENABLE_AUTOLOAD', false);
    Settings::setPdfRenderer(Settings::PDF_RENDERER_DOMPDF, $vendorDirPath . '/dompdf/dompdf');
}
// Set PDF renderer
if (null === Settings::getPdfRendererPath()) {
    $writers['PDF'] = null;
}
// Turn output escaping on
Settings::setOutputEscapingEnabled(true);

/**
 * Write documents
 *
 * @param \PhpOffice\PhpWord\PhpWord $phpWord
 * @param string $filename
 * @param array $writers
 *
 * @return string
 */
function write($phpWord, $filename, $writers = null) {
// Set writers
//$writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');
    if (is_null($writers) || !isset($writers) || $writers == '' || empty($writers)) {
        $writers = array('PDF' => 'pdf');
    }
    $result = '';
    // Write documents
    foreach ($writers as $format => $extension) {
        if (null !== $extension) {
            $targetFile = "{$filename}.{$extension}";
            $phpWord->save($targetFile, $format, true);
        } else {
            throw new \Exception('Informe a extensão do formato ' . $format . '.');
        }
    }

    return true;
}