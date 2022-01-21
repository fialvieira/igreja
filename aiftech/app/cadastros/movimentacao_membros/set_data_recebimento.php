<?php

use modelo\Documento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Documento($id);
    echo json_encode($retorno->getDataCarta());
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}