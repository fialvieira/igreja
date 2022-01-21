<?php

include "../../../def.php";
try {
//  $datacarga = date("Y-m-d H:i:s");
//  $data_servico = substr($dh_fim_servico[0], 6, 4) . substr($dh_fim_servico[0], 3, 2) . substr($dh_fim_servico[0], 0, 2);
//  dd($_FILES['arquivo']);

  $dir = RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/Atas/';
//  d($dir);
  if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
      throw new \Exception('Erro ao tentar criar o diretório.');
    }
  }
  $nome = tiraAcentos($_FILES['arquivo']['name']);
//  $nome = preg_replace(array(
//      "/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/",
//      "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/",
//      "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/",
//      "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/",
//      "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/",
//      "/(ñ)/", "/(Ñ)/"
//          ), explode(" ", "a A e E i I o O u U n N"), $_FILES['arquivo']['name']);

//  $nome = $_FILES['file_evidencia']['name'];
//  $ext = pathinfo($nome, PATHINFO_EXTENSION);
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
?>
