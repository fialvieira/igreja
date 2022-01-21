<?php
use modelo\RelatoriosMembros;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_INCONSISTENCIAS']);
    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }
    $inconsistencias = RelatoriosMembros::inconsistencias();
    $data = date("d_m_Y");
    $file_name = 'Relatorio_inconsistencias_' . $data;
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('AIFTech')
        ->setLastModifiedBy('AIFTech')
        ->setTitle('Relotório de inconsistências')
        ->setSubject('Cadastro de membros')
        ->setDescription('Relatório com os dados de membros com algum tipo de inconsistência.')
        ->setKeywords('relatório membros inconsistência aiftech')
        ->setCategory('Relatórios');

    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Id')
        ->setCellValue('B1', 'Nome')
        ->setCellValue('C1', 'Data Nascimento')
        ->setCellValue('D1', 'CPF')
        ->setCellValue('E1', 'Sexo')
        ->setCellValue('F1', 'Endereço')
        ->setCellValue('G1', 'E-mail')
        ->setCellValue('H1', 'Telefone')
        ->setCellValue('I1', 'Celular')
        ->setCellValue('J1', 'Frequencia');

    $i = 2;
    foreach ($inconsistencias as $k => $v){
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, $v['id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('B' . $i, $v['nome'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, $v['datanascimento'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, $v['cpf'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('E' . $i, $v['sexo'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('F' . $i, $v['endereco'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('G' . $i, $v['email'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('H' . $i, $v['fone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('I' . $i, $v['cel'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('J' . $i, $v['frequencia'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $i++;
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Inconsistências');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save('php://output');
    exit;
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}