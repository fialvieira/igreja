<?php
// Adding an empty Section to the document...
$section = $phpWord->addSection ();
foreach ($retorno as $k => $v) {
    if ($v['local'] != $local_atual) {
        $local_atual = $v['local'];
        $section->addText (
            'ROL DE MEMBROS - ' . $local_atual,
            array('name' => 'Tahoma', 'size' => 16, 'bold' => true)
        );
    }

    if ($v['letra'] != $letra_inicial) {
        $letra_inicial = $v['letra'];
        $section->addText (
            $letra_inicial,
            array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
    }
    $section->addText (
        $v['nome'],
        array('name' => 'Tahoma', 'size' => 10, 'bold' => true)
    );
    if ($v['fone'] != '' || $v['cel'] != '') {
        $section->addText (
            (($v['fone'] != '') ? \bd\Formatos::telefoneApp ($v['fone']) : '') . ' ' . (($v['cel'] != '') ? \bd\Formatos::telefoneApp ($v['cel']) : ''),
            array('name' => 'Tahoma', 'size' => 9)
        );
    }
    if ($v['email'] != '') {
        $section->addText (
            $v['email'],
            array('name' => 'Tahoma', 'size' => 9)
        );
    }
    if ($v['logradouro'] != '' || $v['enderecos_numero'] != '') {
        $section->addText (
            $v['logradouro'] . ' ' . $v['enderecos_numero'],
            array('name' => 'Tahoma', 'size' => 9)
        );
    }
    if ($v['bairro'] != '' || $v['municipio'] != '' || $v['estado'] != '' || $v['cep'] != '') {
        $section->addText (
            $v['bairro'] . ' ' . $v['municipio'] . '/' . $v['estado'] . ' ' . ($v['cep'] != '') ? \bd\Formatos::cepApp ($v['cep']) : '',
            array('name' => 'Tahoma', 'size' => 9)
        );
    }
    $section->addText (
        '',
        array('name' => 'Tahoma', 'size' => 10)
    );
}

// Saving the document as OOXML file...

$filename = 'espelhoteste.docx'; //save our document as this file name
header ('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
header ('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
header ('Cache-Control: max-age=0'); //no cache

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter ($phpWord, 'Word2007');
$objWriter->save ('php://output');