<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_PAGAR'], modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $hoje = date('Ymd-His');
    $dir = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/Movimentacao_Financeira/';
    $codigo = $_POST['codigo'];
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório.');
        }
    }
    $nome = tiraAcentos($_FILES['dir']['name']);
    $upload = $dir . $hoje . '_' . $nome;
    $temp = $_FILES['dir']['tmp_name'];

    /**
     * Salva o arquivo no diretório da empresa
     */
    if (!move_uploaded_file($temp, $upload)) {
        throw new \Exception('Erro Inesperado ao Salvar o Arquivo.');
    }

    /**
     * Salva dados do arquivo no banco
     */
    $retorno = new MovimentacaoFinanceira($codigo);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);

    $retorno->salvaArquivo($upload, $nome);

    $ret = [
        "erro" => false,
        "dir" => $upload, "nome" => $nome
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()
    ];
    echo json_encode($ret);
}