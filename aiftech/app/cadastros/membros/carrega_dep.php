<?php

use modelo\Departamento;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS']);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = Departamento::selecionaPorCargo($id);
    if (empty($retorno)) {
        throw new \Exception('Cargo sem vinculação com departamento');
    }
    include "carrega_dep.html.php";
} catch (\Exception $e) {
    echo $e->getMessage();
}