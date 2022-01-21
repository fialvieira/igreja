<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../../../def.php";
require_once RAIZ . 'vendor/autoload.php';
try {
    Aut::filtraAutorizacao(Aut::$modulos['ACOMPANHAMENTO_ORCAMENTO']);
    $ano = ((isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : null);
    $orcamento = $_SESSION['orcamento'];
    $arrMeses = $_SESSION['orc_arrMeses'];
    $arrTotDespesas = $_SESSION['orc_arrTotDespesas'];

    $locale = 'pt_br';
    $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
    if (!$validLocale) {
        echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
    }

    $data = date("d-m-Y");
    $file_name = 'Acompanhamento_orçamento_' . $ano . '(' . $data . ')';

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    include './planilha_estilos.php';

    // Set document properties
    $spreadsheet->getProperties()->setCreator('AIFTech')
            ->setLastModifiedBy('AIFTech')
            ->setTitle('Acompanhamento Orçamento ' . $ano)
            ->setSubject('Acompanhamento Orçamento ' . $ano)
            ->setDescription('Acompanhamento Orçamento ' . $ano)
            ->setKeywords('acompanhamento orçamento ' . $ano . ' aiftech')
            ->setCategory('Relatórios');

    $spreadsheet->setActiveSheetIndex(0);

    //Set bordar branca em toda planilha
    $spreadsheet->getActiveSheet()->getStyle('A1:BZ100')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $spreadsheet->getActiveSheet()->getStyle('A1:BZ100')->getBorders()->getAllBorders()->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

    //Set Título
    $spreadsheet->getActiveSheet()->setCellValue('C2', 'Orçamento ' . $ano);
    $spreadsheet->getActiveSheet()->mergeCells('C2:R2');
    $spreadsheet->getActiveSheet()->getStyle('C2:R2')->applyFromArray($styleTitulo);

    $i = 4;
    $tipo = '';
    $cat_mae = [];
    $print_month = true;
    $qtd_mes = 0;
    $saldoAcumulado = 0;
    $arrSaldoMes = [];
    foreach ($orcamento as $value) {
        $columnIndex = 5;

        //monta meses e titulos por mês
        if ($tipo != $value['tipo']) {
            $i++;
            foreach ($arrMeses as $mes) {
                if ($print_month) {
                    $spreadsheet->getActiveSheet()
                            ->setCellValueByColumnAndRow($columnIndex, 4, $mes['descricao'] . ' ' . $mes['ano']);
                    $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow($columnIndex, 4, $columnIndex + 3, 4);
                    $spreadsheet->getActiveSheet()
                            ->getStyleByColumnAndRow($columnIndex, 4, $columnIndex + 3, 4)->applyFromArray($styleMeses);
                    $qtd_mes++;
                }
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Previsto');
                $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloPrevisto);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Realizado');
                $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloRealizado);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, '(%)');
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloPorcentagem);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Bonus/Divida');
                $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloBonus);
                $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex++)->setWidth(2.5);
            }

            //monta titulo Acumulado
            if ($print_month) {
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 4, 'Acumulado ' . $ano);
                $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow($columnIndex, 4, $columnIndex + 3, 4);
                $spreadsheet->getActiveSheet()->
                        getStyleByColumnAndRow($columnIndex, 4, $columnIndex + 3, 4)->applyFromArray($styleMeses);
            }
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Previsto');
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloPrevisto);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Realizado');
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloRealizado);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, '(%)');
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloPorcentagem);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $i, 'Bonus/Divida');
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex++, $i)->applyFromArray($styleTituloBonus);

            $print_month = false;

            $tipo = $value['tipo'];
            $spreadsheet->getActiveSheet()
                    ->setCellValue('B' . $i, 'Conta')
                    ->setCellValue('C' . $i, $tipo);
            $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleTiuloColunas);
            $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleTiuloColunas);
        }

        //monta linha de mães
        if ($value['flag_mae'] == 'S') { //Se for conta mae
            if (is_null($value['mae'])) {
                $i++;
                $cat_mae[$value['id']] = 0;
                if ($value['tipo'] == 'Receitas') {
                    $saldoAcumulado += $value['tot_bonus'];
                }
            }

            $columnIndex = 5;

            $spreadsheet->getActiveSheet()
                    ->setCellValueExplicit('B' . $i, $value['num'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                    ->setCellValueExplicit('C' . $i, $value['nome'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleContaMae);
            $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleContaMae);
            if (!is_null($value['mae'])) {
                if (array_key_exists($value['mae'], $cat_mae)) {
                    $cat_mae[$value['id']] = $cat_mae[$value['mae']] + 2;
                }
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setIndent($cat_mae[$value['id']]);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setIndent($cat_mae[$value['id']]);
            }

            foreach ($arrMeses as $mes) {
                $key = array_search($mes['mes'], array_column($value['meses'], 'mes'));
                if ($key === false) {
                    $vlr_previsto = 0;
                    $vlr_realizado = 0;
                    $porcentagem = 0;
                    $bonus = 0;
                } else {
                    $vlr_previsto = $value['meses'][$key]['valor_previsto'];
                    $vlr_realizado = $value['meses'][$key]['valor_realizado'];
                    $porcentagem = $value['meses'][$key]['porcentagem'];
                    $bonus = $value['meses'][$key]['bonus'];
                }
                if ($value['tipo'] == 'Receitas' && is_null($value['mae'])) { //Verifica se conta mãe não possue mãe e é do tipo receita
                    if (array_key_exists($mes['mes'], $arrSaldoMes)) {
                        $arrSaldoMes[$mes['mes']] += $bonus;
                    } else {
                        $arrSaldoMes[$mes['mes']] = $bonus;
                    }
                }
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $vlr_previsto, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePrevisto);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $vlr_realizado, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleRealizado);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $porcentagem, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePorcentagem);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $bonus, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleBonus);
                $columnIndex++;
                $columnIndex++;
            }
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_previsto'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePrevisto);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_realizado'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleRealizado);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_porcentagem'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePorcentagem);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_bonus'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleBonus);

            $i++;
        } else {
            if (is_null($value['mae'])) { //--> indica ser categoria que não possui mãe, portanto é a própria mãe, neste caso insere uma linha em branco.
                $i++;
            }
            $columnIndex = 5;
            $spreadsheet->getActiveSheet()
                    ->setCellValueExplicit('B' . $i, $value['num'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                    ->setCellValueExplicit('C' . $i, $value['nome'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if (is_null($value['mae'])) {
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleContaMae);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleContaMae);
            } else {
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleContas);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleContas);
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setIndent($cat_mae[$value['mae']] + 2);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setIndent($cat_mae[$value['mae']] + 2);
            }
            foreach ($arrMeses as $mes) {
                $key = array_search($mes['mes'], array_column($value['meses'], 'mes'));
                if ($key === false) {
                    $vlr_previsto = 0;
                    $vlr_realizado = 0;
                    $porcentagem = 0;
                    $bonus = 0;
                } else {
                    $vlr_previsto = $value['meses'][$key]['valor_previsto'];
                    $vlr_realizado = $value['meses'][$key]['valor_realizado'];
                    $porcentagem = $value['meses'][$key]['porcentagem'];
                    $bonus = $value['meses'][$key]['bonus'];
                }
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $vlr_previsto, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePrevisto);
                if (is_null($value['mae'])) {
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                }
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $vlr_realizado, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleRealizado);
                if (is_null($value['mae'])) {
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                }
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $porcentagem, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePorcentagem);
                if (is_null($value['mae'])) {
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
                }
                $columnIndex++;
                $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $bonus, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleBonus);
                $columnIndex++;
                $columnIndex++;
            }

            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_previsto'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePrevisto);
            if (is_null($value['mae'])) {
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            }
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_realizado'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleRealizado);
            if (is_null($value['mae'])) {
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            }
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_porcentagem'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($stylePorcentagem);
            if (is_null($value['mae'])) {
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getFont()->setBold(true);
            }
            $columnIndex++;
            $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, $value['tot_bonus'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleBonus);

            $i++;
        }
    }

    //Imprime Total Despesa
    $i++;
    $columnIndex = 5;
    $spreadsheet->getActiveSheet()->setCellValue('B' . $i, 'TOTAL DESPESAS ORÇAMENTÁRIAS');
    $spreadsheet->getActiveSheet()->mergeCells('B' . $i . ':C' . $i);
    $spreadsheet->getActiveSheet()->getStyle('B' . $i . ':C' . $i)->applyFromArray($styleTotDespesas);
    if (count($arrTotDespesas) > 0) {
        
    }
    $meses = (count($arrTotDespesas) > 0) ? $arrTotDespesas['meses'] : $arrMeses;
    foreach ($meses as $mes) {
        $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $mes['valor_previsto'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getAlignment()
                ->setHorizontal(PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()
                ->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
        $columnIndex++;
        $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $mes['valor_realizado'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getAlignment()
                ->setHorizontal(PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()
                ->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
        $columnIndex++;
        $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $mes['porcentagem'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('0.00%');
        $columnIndex++;
        $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $mes['bonus'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('#,##0.00;[red]-#,##0.00');
        $columnIndex++;
        $columnIndex++;
    }
    $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $arrTotDespesas['tot_previsto'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()
            ->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
    $columnIndex++;
    $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $arrTotDespesas['tot_realizado'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()
            ->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
    $columnIndex++;
    $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $arrTotDespesas['tot_porcentagem']: '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('0.00%');
    $columnIndex++;
    $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, (count($arrTotDespesas) > 0) ? $arrTotDespesas['tot_bonus'] : '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('#,##0.00;[red]-#,##0.00');
    $i++;

    //Imprime Saldo
    $i++;
    $columnIndex = 5;
    $spreadsheet->getActiveSheet()->setCellValue('B' . $i, 'SALDO DO MES / SALDO ACUMULADO');
    $spreadsheet->getActiveSheet()->mergeCells('B' . $i . ':C' . $i);
    $spreadsheet->getActiveSheet()->getStyle('B' . $i . ':C' . $i)->applyFromArray($styleTotDespesas);
    foreach ($meses as $mes) {
        if (array_key_exists($mes['mes'], $arrSaldoMes)) {
            $saldo = $arrSaldoMes[$mes['mes']];
        } else {
            $saldo = 0;
        }
        $columnIndex++;
        $columnIndex++;
        $columnIndex++;
        $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, ((count($arrTotDespesas) > 0) ? $saldo + $mes['bonus'] : $saldo + 0), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('#,##0.00;[red]-#,##0.00');
        $columnIndex++;
        $columnIndex++;
    }
    $columnIndex++;
    $columnIndex++;
    $columnIndex++;
    $spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($columnIndex, $i, ((count($arrTotDespesas) > 0) ? $saldoAcumulado + $arrTotDespesas['tot_bonus'] : $saldoAcumulado + 0), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->applyFromArray($styleTotDespesas);
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex, $i)->getNumberFormat()->setFormatCode('#,##0.00;[red]-#,##0.00');

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Orçamento ' . $ano);

    //Ajuste de tamanho de algumas colunas.
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(1.5);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(2.5);

    //Set document security.
    $spreadsheet->getSecurity()->setLockWindows(true);
    $spreadsheet->getSecurity()->setLockStructure(true);
    $spreadsheet->getSecurity()->setWorkbookPassword("abc123>=");

    //Set worksheet security
    $spreadsheet->getActiveSheet()->getProtection()->setPassword('abc123>=');
    $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
    $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
    $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
    $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);

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
    unset($_SESSION['orcamento']);
    unset($_SESSION['orc_arrTotDespesas']);
    exit;
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}