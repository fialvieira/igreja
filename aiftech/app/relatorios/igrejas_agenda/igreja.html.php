<?php

function upperAcentos($palavra) {
    $nome = preg_replace(array(
        "/(á)/","/(à)/","/(ã)/","/(â)/","/(ä)/",
        "/(é)/","/(è)/","/(ê)/","/(ë)/",
        "/(í)/","/(ì)/","/(î)/","/(ï)/",
        "/(ó)/","/(ò)/","/(õ)/","/(ô)/","/(ö)/",
        "/(ú)/","/(ù)/","/(û)/","/(ü)/",
        "/(ç)/",
        "/(ñ)/"
            ), explode(" ", "Á À Ã Â Ä É È Ê Ë Í Ì Î Ï Ó Ò Õ Ô Ö Ú Ù Û Ü Ç Ñ"), $palavra);
    return $nome;
}

function lowerAcentos($palavra) {
    $nome = preg_replace(array(
        "/(Á)/","/(À)/","/(Ã)/","/(Â)/","/(Ä)/",
        "/(É)/","/(È)/","/(Ê)/","/(Ë)/",
        "/(Í)/","/(Ì)/","/(Î)/","/(Ï)/",
        "/(Ó)/","/(Ò)/","/(Õ)/","/(Ô)/","/(Ö)/",
        "/(Ú)/","/(Ù)/","/(Û)/","/(Ü)/",
        "/(Ç)/",
        "/(Ñ)/"
            ), explode(" ", "á à ã â ä é è ê ë í ì î ï ó ò õ ô ö ú ù û ü ç ñ"), $palavra);
    return $nome;
}

// Adding an empty Section to the document...
$section = $phpWord->addSection();
foreach ($retorno as $v) {
    if ($v['associacao'] != $associacao_atual) {
        $associacao_atual = $v['associacao'];
        if ($associacao_atual != '') {
            $section->addText(
                    'IGREJAS DA ' . $associacao_atual, array('name' => 'Tahoma', 'size' => 16, 'bold' => true), array('align' => 'center')
            );
        } else {
            $section->addText(
                    '', array('name' => 'Tahoma', 'size' => 16, 'bold' => true)
            );
        }
    }


//    if ($v['letra'] != $letra_inicial) {
//        $letra_inicial = $v['letra'];
//        $section->addText(
//                $letra_inicial, array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
//        );
//    }
    if (upperAcentos(strtoupper($v['municipio'])) != $cidade_atual) {
        $cidade_atual = upperAcentos(strtoupper($v['municipio']));
        $section->addText(
                $cidade_atual, array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
    }

    $section->addText(
            upperAcentos(strtoupper($v['nome'])), array('name' => 'Tahoma', 'size' => 10, 'bold' => true)
    );
    if ($v['logradouro'] != '' || $v['numero'] != '' || $v['bairro'] != '') {
        $section->addText(
                ucwords(lowerAcentos(strtolower($v['logradouro'] . ', ' . $v['numero'] . ' ' . $v['bairro']))), array('name' => 'Tahoma', 'size' => 9)
        );
    }
    if ($v['municipio'] != '' || $v['estado'] != '' || $v['cep'] != '') {
        $section->addText(
                ucwords(lowerAcentos(strtolower($v['municipio']))) . '/' . $v['estado'] . ' ' . (($v['cep'] != '') ? \bd\Formatos::cepApp($v['cep']) : '') . ' ' .
                (($v['telefone'] != '') ? \bd\Formatos::telefoneApp($v['telefone']) : ''), array('name' => 'Tahoma', 'size' => 9)
        );
    }
//    if ($v['telefone'] != '' || $v['celular'] != '') {
//        $section->addText(
//                (($v['telefone'] != '') ? \bd\Formatos::telefoneApp($v['telefone']) : '') . ' ' . (($v['celular'] != '') ? \bd\Formatos::telefoneApp($v['celular']) : ''), array('name' => 'Tahoma', 'size' => 9)
//        );
//    }
    if ($v['pastor'] != '') {
        $section->addText(
                ucwords(lowerAcentos(strtolower($v['pastor']))) . ' ' . $v['email'], array('name' => 'Tahoma', 'size' => 9)
        );
    }
    $section->addText(
            '', array('name' => 'Tahoma', 'size' => 10)
    );
}

// Saving the document as OOXML file...

$filename = 'espelhoteste.docx'; //save our document as this file name
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');
