<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['PASTORES'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Pastor($id);
    $funcoes = modelo\Pastor::FUNCAO;
    $filtro = explode(",", $id);
    $manual = RAIZ . "docs/manuais/Modulo_Cadastro_de_Pastor.pdf";
    include "pastor.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}