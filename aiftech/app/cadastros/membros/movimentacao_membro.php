<?php
use modelo\Ata;
use modelo\Membro;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::REWRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Membro($id);
    $data_batismo = $retorno->getDatabatismo();
    $atas = Ata::seleciona($retorno->getNome());
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";
    include "movimentacao_membro.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}