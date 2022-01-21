<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['DONS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Dom($id);
    $filtro = explode(",", $id);
    include "dom.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}