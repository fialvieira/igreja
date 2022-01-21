<?php
use modelo\Membro;
use modelo\MovimentacaoMembro;
include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::VIEWER);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Membro($id);
    $mm = MovimentacaoMembro::listaMovimentacaoMembros($retorno->getId());
    include 'pesquisa.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}