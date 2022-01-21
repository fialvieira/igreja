<?php
use modelo\Relacionamento;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::REWRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Membro($id);
    $parentesco = \modelo\Relacionamento::seleciona($retorno->getId());
    $parentesco = array_filter($parentesco);
    $tipos_parentesco = \modelo\Tiporelacionamento::seleciona();
    $membros = \modelo\Membro::selecionaTodos();
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";
    include "parentesco.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}