<?php
include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $path = (isset($_GET["path"]) && $_GET["path"] != "" && $_GET['path'] != 'undefined') ? $_GET["path"] : null;
    if (!is_null($path)) {
        if (unlink($path)) {
            $ret = ["erro" => false, "mensagem" => "Arquivo excluído com sucesso"];
        } else {
            throw new \Exception('Erro ao excluir arquivo');
        }
    } else {
        $ret = ["erro" => false, "mensagem" => "Não existe arquivo para ser excluído"];
    }
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}