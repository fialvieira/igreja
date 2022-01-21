<?php

use modelo\DocumentoTipo;
use modelo\Documento;
use modelo\Membro;

include "../../../def.php";
include_once './phpWordConfig.php';

try {
    Aut::filtraAutorizacao(Aut::$modulos['DOCUMENTOS']);
    if (!isset($_GET['id']) OR $_GET['id'] == '') {
        $id = null;
    } else {
        $id = $_GET['id'];
    }
    if (!isset($_GET['membro']) OR $_GET['membro'] == '') {
        $membros_id = null;
    } else {
        $membros_id = $_GET['membro'];
    }
    $doc = new Documento($id);
//    $presidente_pastor = new Membro($doc->getPresidencia());
//    $secretario = new Membro($doc->getSecretario());
//    $cargos_secretario = Membro::getCargoSecretarioEmpresa();
//    if (array_search($secretario->getCargoId(), $cargos_secretario)) {
//        $secretario_cargo = $secretario->getCargoAtivo();
//    } else {
//        $secretario_cargo = 'Secretario(a) Ad hoc';
//    }
    $presidente_pastor = Membro::getCargosMembro($doc->getPresidencia(), substr($doc->getData(), 6, 4));
    $secretario = Membro::getCargosMembro($doc->getSecretario(), substr($doc->getData(), 6, 4));
    $cargos_secretario = Membro::getCargoSecretarioEmpresa();    
    $presidente_nome = $presidente_pastor[0]['nome'];
    $presidente_cpf = bd\Formatos::cpfApp($presidente_pastor[0]['cpf']);    
    $presidente_rg = $presidente_pastor[0]['rg'];    
    $presidente_cargo = ($presidente_pastor[0]['abreviacao'] != '')? $presidente_pastor[0]['abreviacao'] : $presidente_pastor[0]['cargo'];    
    $secretario_nome = '';
    $secretario_cargo = 'Secretario(a) Ad hoc';
    foreach ($secretario as $s) {
      $secretario_nome = $s['nome'];
      if (array_search($s['cargo_id'], $cargos_secretario) !== false) {
        $secretario_cargo = $s['abreviacao'];
        break;
      }  
    }
    
    $temp = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/documentos/temp/';
//    $dir = 'C:\\aiftech\\documentos\\';
    if (!file_exists($temp)) {
        if (!mkdir($temp, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório documentos\\temp.');
//      throw new \Exception('Erro ao tentar criar o diretório aiftech\documentos no C:\\');
        }
    }

    $tipo_modelo = new DocumentoTipo($doc->getTipoDocumento());
    $modelo = $tipo_modelo->getPathModelo();
    $listaMembros = \modelo\Membro::getMembrosByListaId($membros_id);
    $presidente = Membro::getPresidenteEmpresa();
    $igreja = new \modelo\Empresa(EMPRESA);
    $end_igreja = new modelo\Endereco($igreja->getEndereco());
    $estado_igreja = new modelo\Estado($end_igreja->getEstado());
    $igreja_destino = new \modelo\Empresa($doc->getIgrejaDestinoId());
    $end_igreja_destino = new modelo\Endereco($igreja_destino->getEndereco());

//    switch ($doc->getExtensao()) {
//        case 'd':
//            $ext = ['Word2007' => 'docx'];
//            break;
//        case 'p':
//            $ext = ['PDF' => 'PDF'];
//            break;
//        case 'h':
//            $ext = ['HTML' => 'html'];
//            break;
//        case 'o':
//            $ext = ['ODText' => 'odt'];
//            break;
////        case 'rtf':
////            $ext = ['RTF' => 'rtf'];
////            break;
//        default:
//            $ext = ['PDF' => 'PDF'];
//            break;
//    }
// Cria instancia do Template processor
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($modelo);
    $listaVariaveis = $templateProcessor->getVariables();
    $arrData = explode('/', $doc->getData());
    $dataExtenso = convertNumToWords((int) $arrData[0]) . ' de ' . strtolower(mesPorExtenso($arrData[1])) .
            ' de ' . convertNumToWords($arrData[2]);
    $dataMesExtenso = $arrData[0] . ' de ' . strtolower(mesPorExtenso($arrData[1])) .
            ' de ' . $arrData[2];
    $horaExtenso = '';
    if ($doc->getHora()) {
        $arrHora = explode(':', $doc->getHora());
        $horaExtenso = convertNumToWords((int) $arrHora[0]) . ' horas';
        $horaExtenso .= ((int) $arrHora[1]) ? ' e ' . convertNumToWords((int) $arrHora[1]) . ' minutos' : '';
    }
    $dataAtaExtenso = '';
    if ($doc->getDataAta()) {
        $arrDataAta = explode('/', $doc->getDataAta());
        $dataAtaExtenso = convertNumToWords((int) $arrDataAta[0]) . ' de ' . strtolower(mesPorExtenso($arrDataAta[1])) .
                ' de ' . convertNumToWords($arrDataAta[2]);
    }
    $nome_membros = '';
    foreach ($listaMembros as $membro) {
        $nome_membros .= '; ' . $membro['nome'];
    }
    $nome_membros = substr($nome_membros, 2);
    $endereco_igreja = $end_igreja->getLogradouro() . ', ' . $igreja->getNumero();
    $endereco_igreja .= ($igreja->getComplemento()) ? ', ' . $igreja->getComplemento() : '';
    $endereco_igreja .= ', ' . $end_igreja->getBairro();
    $endereco_ig_dest = $end_igreja_destino->getLogradouro() . ', ' . $igreja_destino->getNumero();
    $endereco_ig_dest .= ($igreja_destino->getComplemento()) ? ', ' . $igreja_destino->getComplemento() : '';
    $endereco_ig_dest .= ', ' . $end_igreja_destino->getBairro();

//---> Altera tags do documento
    $templateProcessor->setValue('numeroDocumento', $doc->getNum());
//    $templateProcessor->setValue('nomePastor', $presidente_pastor->getNome());
//    $templateProcessor->setValue('cargoPastor', $presidente_pastor->getCargoAtivo());
//    $templateProcessor->setValue('rgPastor', $presidente_pastor->getRg());
//    $templateProcessor->setValue('cpfPastor', $presidente_pastor->getCpf());
    $templateProcessor->setValue('nomePastor', $presidente_nome);
    $templateProcessor->setValue('cargoPastor', $presidente_cargo);
    $templateProcessor->setValue('rgPastor', $presidente_rg);
    $templateProcessor->setValue('cpfPastor', $presidente_cpf);

    $templateProcessor->setValue('data', $doc->getData());
    $templateProcessor->setValue('dataExtenso', $dataExtenso);
    $templateProcessor->setValue('dataMesExtenso', $dataMesExtenso);
    $templateProcessor->setValue('horaExtenso', $horaExtenso);

    $templateProcessor->setValue('nomeIgreja', $igreja->getNome());
    $templateProcessor->setValue('nomeIgrejaUpper', strtoupper($igreja->getNome()));
    $templateProcessor->setValue('cnpjIgreja', $igreja->getCnpj());
    $templateProcessor->setValue('enderecoIgreja', $endereco_igreja);
    $templateProcessor->setValue('cidadeIgreja', $end_igreja->getLocalidade());
    $templateProcessor->setValue('estadoIgreja', $estado_igreja->getNome());
    $templateProcessor->setValue('cidadeUfIgreja', $end_igreja->getLocalidade() . ' - ' . $end_igreja->getEstadoSigla());

    $templateProcessor->setValue('nomePresidente', $presidente['nome']);
    $templateProcessor->setValue('rgPresidente', $presidente['rg']);
    $templateProcessor->setValue('cpfPresidente', bd\Formatos::cpfApp($presidente['cpf']));

    $templateProcessor->setValue('nomeMembro', $membro['nome']);
    $templateProcessor->setValue('nomeMembroUpper', strtoupper($membro['nome']));
    $templateProcessor->setValue('rgMembro', $membro['rg']);
    $templateProcessor->setValue('cpfMembro', bd\Formatos::cpfApp($membro['cpf']));
    $endereco = $membro['logradouro'] . ', ' . $membro['enderecos_numero'];
    $endereco .= ($membro['enderecos_complemento']) ? ', ' . $membro['enderecos_complemento'] : '';
    $endereco .= ', ' . $membro['bairro'];
    $templateProcessor->setValue('enderecoMembro', $endereco);
    $templateProcessor->setValue('cidadeUfMembro', $membro['localidade'] . ' - ' . $membro['sigla']);
    $templateProcessor->setValue('CEPMembro', \bd\Formatos::cepApp($membro['cep']));
    $templateProcessor->setValue('dataAta', $doc->getDataAta());
    $templateProcessor->setValue('dataAtaExtenso', $dataAtaExtenso);
    
    $templateProcessor->setValue('nomeSecretario', $secretario_nome);
    $templateProcessor->setValue('cargoSecretario', $secretario_cargo);
//    $templateProcessor->setValue('nomeSecretario', $secretario->getNome());
//    $templateProcessor->setValue('cargoSecretario', $secretario_cargo);

    $templateProcessor->setValue('nomeIgrejaDestino', $igreja_destino->getNome());
    $templateProcessor->setValue('enderecoIgrejaDestino', $endereco_ig_dest);
    $templateProcessor->setValue('cidadeUfIgrejaDestino', $end_igreja_destino->getLocalidade() . ' - ' . $end_igreja_destino->getEstadoSigla());
    $templateProcessor->setValue('CEPIgrejaDestino', $end_igreja_destino->getCep());
    $templateProcessor->setValue('pastorIgrejaDestino', $doc->getPastorDestino());

    $templateProcessor->setValue('nomeDestinatario', $membro['nome']);
    $templateProcessor->setValue('enderecoDest', $endereco);
    $templateProcessor->setValue('cidadeUfDest', $membro['localidade'] . ' - ' . $membro['sigla']);
    $templateProcessor->setValue('CEPDest', $membro['cep']);

    $templateProcessor->setValue('dataCartaRecebida', $doc->getDataCarta());
//    $templateProcessor->setValue('dataAta', $doc->getDataAta());
    $templateProcessor->setValue('listaNomesMembros', $nome_membros);

    $nome = tiraAcentos($doc->getTipoDesc() . ' - ' . $membro['nome']);
    if (array_search('listaNomesMembros', $listaVariaveis) !== false) {
        $nome = tiraAcentos($doc->getTipoDesc() . ' - ' . date('d-m-Y'));
    }

    $nome_temp = $nome . '_temp.docx';
    // Salva documento temporário com tags alteradas    
    $source = $temp . $nome_temp;
//  $source = $dir . $nome . '.docx';
    $templateProcessor->saveAs($source);

//  if (!file_exists($source)) {
//    echo 'Arquivo não encontrado, verifique!';
//    die();
//  }
//  d(basename($source));
//  d($nome.'.docx');
//  exit;
    header('Content-Description: File Transfer');
    header('Content-Disposition: inline; filename="' . basename($source) . '"');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($source));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');

    readfile($source);

//    // Lê conteudo do documento temporário
//    $phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
////    $phpWord = \PhpOffice\PhpWord\IOFactory::load($modelo);
//    if (is_null($phpWord)) {
//        throw new \Exception('Erro ao gerar arquivo temporário.');
//    }
//
//    // Salva documento final
//    $result = write($phpWord, $nome, $ext);
//    if (!$result) {
//        throw new \Exception('Não foi possível criar arquivo ' . $nome);
//    }
//    exit;
    //exclui arquivo temporário usado para gerar arquivo final
    if (file_exists($source)) {
        unlink($source);
    }

//  $ret = ["erro" => false, "nome" => $nome];
} catch (\Exception $e) {
//    templates\Igreja::erro($e);
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}
?>
