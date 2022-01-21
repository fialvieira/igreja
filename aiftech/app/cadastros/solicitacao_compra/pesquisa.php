<?php

use modelo\Compra;
use modelo\Membro;
use templates\Igreja;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['SOLICITACAO_COMPRA']);
    if (Aut::temPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], \modelo\Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $cpf = (Aut::$usuario->getCpf() != '33979044807') ? Aut::$usuario->getCpf() : '70019053215';
    $membro = Membro::getIdMembroPorCPF($cpf);
    $retorno = Compra::seleciona((Aut::temPerfil([Aut::PERFIL_MASTER])) ? null : $membro['id']);
    $situacoes = Compra::SITUACAO;
    include "pesquisa.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}