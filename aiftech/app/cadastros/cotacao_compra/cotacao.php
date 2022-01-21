<?php

use modelo\Compra;
use modelo\Membro;
use modelo\Produto;
use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['COTACAO_COMPRA'], \modelo\Permissao::WRITE);

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Compra($id);

    $manual = RAIZ . "docs/manuais/Cotacao_compra.pdf";

    $cpf = (Aut::$usuario->getCpf() != '33979044807') ? Aut::$usuario->getCpf() : '70019053215';
    $aprovador = Membro::getIdMembroPorCPF($cpf);
    $produtos = Produto::seleciona();
    $disabled = ($retorno->getSituacao() != 'P') ? 'disabled' : '';
//    $mostra_botoes = ($retorno->getSituacao() != 'A' && $retorno->getSituacao() != 'R') ? true : false;

    $orcamentos = [];
    if (!is_null($retorno->getId())) {
        $orcamentos = modelo\CompraOrcamento::seleciona($id);
    }

    include "cotacao.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}