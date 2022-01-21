<?php

use modelo\Membro;
use modelo\RelatoriosMembros;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_GERAL']);
    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }
    $ativo = ((isset($_GET["sel_status"]) && $_GET["sel_status"] != "") ? $_GET["sel_status"] : null);
    $quorum = ((isset($_GET["quorum"]) && $_GET["quorum"] != "") ? $_GET["quorum"] : null);
    $inconsistencias = RelatoriosMembros::membros($ativo, $quorum);
    $data = date("d_m_Y");
    $file_name = 'Relatorio_membros_' . $data;
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('AIFTech')
        ->setLastModifiedBy('AIFTech')
        ->setTitle('Relotório de membros')
        ->setSubject('Cadastro de membros')
        ->setDescription('Relatório com os dados de membros.')
        ->setKeywords('relatório membros completo aiftech')
        ->setCategory('Relatórios');

    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Id')
        ->setCellValue('B1', 'Frequencia')
        ->setCellValue('C1', 'Nome')
        ->setCellValue('D1', 'Data Nascimento')
        ->setCellValue('E1', 'CPF')
        ->setCellValue('F1', 'RG')
        ->setCellValue('G1', 'Sexo')
        ->setCellValue('H1', 'Naturalidade')
        ->setCellValue('I1', 'Naturalidade Estado')
        ->setCellValue('J1', 'Estado Civil')
        ->setCellValue('K1', 'Data Casamento')
        ->setCellValue('L1', 'Local')
        ->setCellValue('M1', 'CEP')
        ->setCellValue('N1', 'Logradouro')
        ->setCellValue('O1', 'Bairro')
        ->setCellValue('P1', 'Cidade')
        ->setCellValue('Q1', 'Estado')
        ->setCellValue('R1', 'Numero')
        ->setCellValue('S1', 'Complemento')
        ->setCellValue('T1', 'E-mail')
        ->setCellValue('U1', 'Telefone')
        ->setCellValue('V1', 'Celular')
        ->setCellValue('W1', 'Status')
        ->setCellValue('X1', 'Quórum')
        ->setCellValue('Y1', 'Profissao')
        ->setCellValue('Z1', 'Escolaridade')
        ->setCellValue('AA1', 'Ministérios Interesse')
        ->setCellValue('AB1', 'Data Batismo');

    $i = 2;
    foreach ($inconsistencias as $k => $v) {
        $retorno = new Membro($v['id']);
        $deps = $retorno->getDepartamentosInteresse();
        $di = '';
        foreach ($deps as $dep) {
            $di .= $dep['nome'] . ', ';
        }
        $di = substr_replace($di, ' ', strlen($di) - 2, 1);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, $v['id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('B' . $i, $v['frequencia'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, $v['nome'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, \bd\Formatos::dataApp($v['datanascimento']),
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('E' . $i, $v['cpf'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('F' . $i, $v['rg'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('G' . $i, $v['sexo'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('H' . $i, $v['naturalidade'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('I' . $i, $v['estado_descricao'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('J' . $i, $v['estado_civil'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('K' . $i, \bd\Formatos::dataApp($v['data_casamento']),
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('L' . $i, $v['locais'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('M' . $i, $v['cep'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('N' . $i, $v['logradouro'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('O' . $i, $v['bairro'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('P' . $i, $v['localidade'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('Q' . $i, $v['enderecos_estado'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('R' . $i, $v['enderecos_numero'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('S' . $i, $v['enderecos_complemento'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('T' . $i, $v['email'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('U' . $i, $v['fone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('V' . $i, $v['cel'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('W' . $i, $v['status'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('X' . $i, $v['quorum'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('Y' . $i, $v['profissoes_descricao'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('Z' . $i, $v['escolaridade_descricao'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('AA' . $i, $di,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
            ->setCellValueExplicit('AB' . $i, \bd\Formatos::dataApp($v['databatismo']),
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
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