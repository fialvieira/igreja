<?php

use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $path = 'arquivos/empresa_id_' . EMPRESA . '/fotos/';
    $dir = RAIZ . $path;
    $id = $_POST["id"];
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            throw new \Exception('Erro ao tentar criar o diretório.');
        }
    }
    $nome = preg_replace(array(
        "/(á|à|ã|â|ä)/",
        "/(Á|À|Ã|Â|Ä)/",
        "/(é|è|ê|ë)/",
        "/(É|È|Ê|Ë)/",
        "/(í|ì|î|ï)/",
        "/(Í|Ì|Î|Ï)/",
        "/(ó|ò|õ|ô|ö)/",
        "/(Ó|Ò|Õ|Ô|Ö)/",
        "/(ú|ù|û|ü)/",
        "/(Ú|Ù|Û|Ü)/",
        "/(ñ)/",
        "/(Ñ)/"
    ), explode(" ", "a A e E i I o O u U n N"), $_FILES['arquivo']['name']);
    $nome = str_replace(' ', '_', $nome);
//  $nome = $_FILES['file_evidencia']['name'];
//  $ext = pathinfo($nome, PATHINFO_EXTENSION);
//    d($nome);
    $upload = $dir . $nome;
    $path .= $nome;
    $temp = $_FILES['arquivo']['tmp_name'];
/*    d($upload);
    dd($temp);*/
    if (!move_uploaded_file($temp, $upload)) {
        throw new \Exception('Erro Inesperado ao Salvar o Arquivo.');
    }
    $m = new Membro($id);
    $m->setImagem($path);
    $m->gravaImagem();
    $ret = ["erro" => false, "dir" => $upload, "nome" => $nome];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
