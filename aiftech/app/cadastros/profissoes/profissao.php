<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['PROFISSOES'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Profissao($id);
    $filtro = explode(",", $id);
    include "profissao.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}