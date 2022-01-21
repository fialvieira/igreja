<?php
// Adding an empty Section to the document...
$section = $phpWord->addSection();
foreach ($aniversariantes as $k => $v) {
    if ($v['mes'] != $mes_atual) {
        $mes_atual = $v['mes'];
        $section->addText(
            mesPorExtenso($mes_atual),
            array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
    }
    $section->addText(
        substr(\bd\Formatos::dataApp($v['aniversario']), 0, 5) . ' ' . $v['nome'],
        array('name' => 'Tahoma', 'size' => 10, 'bold' => false)
    );
    $section->addText(
        '',
        array('name' => 'Tahoma', 'size' => 10)
    );
}

// Saving the document as OOXML file...

$filename = 'Aniversariantes_Anual_' . $dh_atual . '.docx'; //save our document as this file name
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');