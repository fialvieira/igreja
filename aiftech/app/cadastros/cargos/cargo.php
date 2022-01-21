<?php

use modelo\Departamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CARGOS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Cargo($id);
    $filtro = explode(",", $id);
    $departamentos = Departamento::seleciona('S', null, null);
    if (!is_null($id)) {
        $cargo_dep = $retorno->getCargosDepartamentos();
    }
    include "cargo.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}