<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['DEPARTAMENTOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Departamento($id);
    $filtro = explode(",", $id);
    include "departamento.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}