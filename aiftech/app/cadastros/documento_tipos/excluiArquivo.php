<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['TIPOS_DOCUMENTO'], modelo\Permissao::WRITE);
    $dir = $_GET['dir'];
    if (!file_exists($dir)) {
        throw new Exception('Arquivo não encontrado.');
    } else {
        if (!unlink($dir)) {
            throw new \Exception('Erro Inesperado ao excluir o Arquivo');
        }
    }

    $ret = ["erro" => false];
} catch (\Exception $ex) {
    $ret = ["erro" => true, "mensagem" => $ex->getMessage()];
}
echo json_encode($ret);
