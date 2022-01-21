<?php

use modelo\Compra;
use modelo\Membro;
use modelo\Produto;
use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], \modelo\Permissao::WRITE);

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Compra($id);

    $manual = RAIZ . "docs/manuais/Aprovacao_compra.pdf";

    $cpf = (Aut::$usuario->getCpf() != '33979044807') ? Aut::$usuario->getCpf() : '70019053215';
    $aprovador = Membro::getIdMembroPorCPF($cpf);
    $produtos = Produto::seleciona();
    $disabled = ($retorno->getSituacao() != 'S' && $retorno->getSituacao() != '') ? 'disabled' : '';
    $mostra_botoes = ($retorno->getSituacao() != 'A' && $retorno->getSituacao() != 'R') ? true : false;

    include "solicitacao.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}