<?php

use modelo\Ata;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['ATAS'], modelo\Permissao::WRITE);
    $dir = $_GET['dir'];
    $ata = $_GET['ata'];
    $id = (isset($_GET['id']) && $_GET['id'] != 'undefined') ? $_GET['id'] : NULL;

    if (unlink($dir) === false) {
        throw new \Exception('Erro Inesperado ao excluir o Arquivo');
    }
    if (!is_null($id)) {
        $r = new Ata($ata);
        $r->excluiArquivo($id);
    }
    $ret = ["erro" => false];
} catch (\Exception $ex) {
    $ret = ["erro" => true, "mensagem" => $ex->getMessage()];
}
echo json_encode($ret);
