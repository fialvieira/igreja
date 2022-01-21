<?php

use modelo\Compra;
use modelo\Membro;
use modelo\Produto;
use modelo\CategoriasFinanceira;
use templates\Igreja;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], \modelo\Permissao::WRITE);

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Compra($id);

    $manual = RAIZ . "docs/manuais/Solicitação de Compras.pdf";

//---> utilizado para testes homologação Marlon    
    /*$cpf = (Aut::$usuario->getCpf() != '33979044807') ? Aut::$usuario->getCpf() : '70019053215';
    $solicitante = Membro::getIdMembroPorCPF($cpf);*/
//<---    
    $solicitante = Membro::getIdMembroPorCPF(Aut::$usuario->getCpf()); //--> ativar após testes
    $produtos = Produto::seleciona();
    $c = CategoriasFinanceira::getCategoriasFilhas('S', 'D');

    foreach ($c as $v) {
        $contas[] = $v;
    }
    $disabled = ($retorno->getSituacao() != 'S' && $retorno->getSituacao() != '') ? 'disabled' : '';
    include "solicitacao.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}