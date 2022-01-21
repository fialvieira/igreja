<?php

use modelo\MovimentacaoMembro;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_MOVIMENTACAO']);
    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }

    $id = (isset($_GET["membro"]) && $_GET["membro"] != "") ? $_GET["membro"] : null;
    $tipo_movimentacao = (isset($_GET["tipo_movimentacao"]) && $_GET["tipo_movimentacao"] != "") ? $_GET["tipo_movimentacao"] : null;
    $ata_id = (isset($_GET["ata_id"]) && $_GET["ata_id"] != "") ? $_GET["ata_id"] : null;
    $data_inicial = (isset($_GET["data_inicial"]) && $_GET["data_inicial"] != "") ? $_GET["data_inicial"] : null;
    $data_final = (isset($_GET["data_final"]) && $_GET["data_final"] != "") ? $_GET["data_final"] : null;

    $mm = MovimentacaoMembro::relatorioMovimentacaoMembros($id, $tipo_movimentacao, $ata_id, $data_inicial, $data_final);

    if (count($mm) == 0) {
        throw new Exception("Não existem registros");
    }

    $data = date("d_m_Y");
    $file_name = 'Relatorio_movimentacao_membros_' . $data;
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('AIFTech')
        ->setLastModifiedBy('AIFTech')
        ->setTitle('Relotório de movimentação de membros')
        ->setSubject('Cadastro de membros')
        ->setDescription('Relatório com os dados de movimentação de membros.')
        ->setKeywords('relatório movimentação membros completo aiftech')
        ->setCategory('Relatórios');

    // Cabeçalho
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Enviada')
        ->setCellValue('B1', 'Chegou')
        ->setCellValue('C1', 'Ata')
        ->setCellValue('D1', 'Data')
        ->setCellValue('E1', 'Motivo')
        ->setCellValue('F1', 'Membro')
        ->setCellValue('G1', 'Igreja Origem');

    $i = 2;
    $tipo_movimento = '';
    foreach ($mm as $k => $v) {
        if ($tipo_movimento == '') {
            $tipo_movimento = $v['tipo_movimentacao'];
            $texto = MovimentacaoMembro::TIPO_MM[$tipo_movimento];
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $texto);
            $i++;
        } else {
            if ($tipo_movimento != $v['tipo_movimentacao']){
                $tipo_movimento = $v['tipo_movimentacao'];
                $texto = MovimentacaoMembro::TIPO_MM[$tipo_movimento];
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $texto);
                $i++;
            }
        }

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, ($v['data_carta_envio'] != '') ? \bd\Formatos::dataApp($v['data_carta_envio']) : '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('B' . $i, ($v['data_carta_recebimento'] != '') ? \bd\Formatos::dataApp($v['data_carta_recebimento']) : '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, $v['ata_numero'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, ($v['data_mov'] != '') ? \bd\Formatos::dataApp($v['data_mov']) : '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('E' . $i, $v['tp_mov'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('F' . $i, $v['nome'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('G' . $i, $v['igreja'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $i++;
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Membros');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '.xls"');
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