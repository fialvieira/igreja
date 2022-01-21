<?php

include "../../../def.php";
try {
//  $datacarga = date("Y-m-d H:i:s");
//  $data_servico = substr($dh_fim_servico[0], 6, 4) . substr($dh_fim_servico[0], 3, 2) . substr($dh_fim_servico[0], 0, 2);

    $dir = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/Atas/';
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório.');
        }
    }
    $nome = tiraAcentos($_FILES['arquivo']['name']);
    $upload = $dir . $nome;
    $temp = $_FILES['arquivo']['tmp_name'];
    if (move_uploaded_file($temp, $upload) === false) {
        throw new \Exception('Erro Inesperado ao Salvar o Arquivo ' . $_FILES['arquivo']['name'] . '.');
    }

    $ret = ["erro" => false, "dir" => $upload, "nome" => $nome];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
?>
