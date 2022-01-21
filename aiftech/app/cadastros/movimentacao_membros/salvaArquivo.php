<?php

include "../../../def.php";
try {
    $dir = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/movimentacao_membros/';
//  d($dir);
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório.');
        }
    }
    $nome = tiraAcentos($_FILES['arquivo']['name']);
//  d($nome);
    $upload = $dir . $nome;
    $temp = $_FILES['arquivo']['tmp_name'];
//  d($upload);
//  dd($temp);
    if (!move_uploaded_file($temp, $upload)) {
        throw new \Exception('Erro Inesperado ao Salvar o Arquivo.');
    }
    $ret = ["erro" => false, "dir" => $upload, "nome" => $nome];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);