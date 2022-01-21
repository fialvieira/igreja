<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['ASSOCIACOES'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Associacao($id);
    $filtro = explode(",", $id);
    include "associacao.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}