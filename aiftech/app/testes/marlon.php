<?php

include '../../def.php';
include_once './phpWordConfig.php';
try {
    $dir = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/documentos/modelos/';
    $temp = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/documentos/temp/';
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório documentos / modelos.');
        }
    }
    if (!file_exists($temp)) {
        if (!mkdir($temp, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório documentos / temp.');
        }
    }
    $nome = 'qualquer_um';
    $modelo = $dir . 'carta_1_aviso_desligamento.docx';
    $nome_temp = $nome . '_temp.docx';
    $tipo = 'doc';
    switch ($tipo) {
        case 'doc':
            $ext = ['Word2007' => 'docx'];
            break;
        case 'pdf':
            $ext = ['PDF' => 'PDF'];
            break;
        case 'html':
            $ext = ['HTML' => 'html'];
            break;
        case 'odt':
            $ext = ['ODText' => 'odt'];
            break;
        case 'rtf':
            $ext = ['RTF' => 'rtf'];
            break;
        default:
            $ext = ['PDF' => 'PDF'];
            break;
    }

// Cria instancia do Template processor
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($modelo);

// Altera tags do documento
    $templateProcessor->setValue('nomePastor', 'Jeferson');
    $templateProcessor->setValue('cargoPastor', 'Pastor Titular');
//    $hoje = date('d/m/Y');
    $data = convertNumToWords((int) date('d')) . ' de ' . strtolower(mesPorExtenso(date('m'))) . 
            ' de ' . convertNumToWords(date('Y'));
    $templateProcessor->setValue('dataExtenso', $data);
    $templateProcessor->setValue('nomeMembro', 'Rômulo Silva');
    $templateProcessor->setValue('enderecoMembro', 'Rua Teste Testando, nº 1-15, lote 2, Vila Alguma');
    $templateProcessor->setValue('cidadeUfMembro', 'Bauru - SP');
    $templateProcessor->setValue('CEPMembro', '17020-000');
//    $templateProcessor->setValue('nomePastor', 'Jeferson');
//    $templateProcessor->setValue('cargoPastor', 'Pastor Titular');
    $templateProcessor->setValue('nomeSecretario', 'Gisele');
    $templateProcessor->setValue('cargoSecretario', '1º Secretario(a)');
    

// Salva documento temporário com tags alteradas    
    $source = $temp . $nome_temp;
    $templateProcessor->saveAs($source);

// Lê conteudo do documento temporário
    $phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
    if (is_null($phpWord)) {
        throw new \Exception('Erro ao gerar arquivo temporário.');
    }

// Salva documento final
    $result = write($phpWord, $nome, $ext);
    if (!$result) {
        throw new \Exception('Não foi possível criar arquivo ' . $nome);
    }
    
//exclui arquivo temporário usado para gerar arquivo final
    if (file_exists($source)) {
        unlink($source);
    }

    echo 'Documento gerado com sucesso.';
} catch (Exception $e) {
    \templates\Igreja::erro($e);
}