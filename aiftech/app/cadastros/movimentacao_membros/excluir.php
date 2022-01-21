<?php

use bd\Formatos;
use modelo\Dom;
use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\MovimentacaoMembro($id);
    $retorno->exclui();
    $ret = [
        "erro" => false,
        "mensagem" => 'Registro excluído com sucesso'
    ];
} catch (\Exception $e) {
    $ret = ["erro" => true,
        "mensagem" => $e->getMessage()
    ];
}
echo json_encode($ret);