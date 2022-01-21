<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['DOCUMENTOS'], \modelo\Permissao::DEL);
    
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    if (is_null($id) || $id == '') {
        throw new \Exception('Obrigatório informar um documento para ser excluído.');
    }
    $res = modelo\Documento::exclui($id);
    
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
?>