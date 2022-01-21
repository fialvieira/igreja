<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['BANCOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Banco($id);
    $filtro = explode(",", $id);
    include "banco.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}