<?php

use modelo\Compra;
use modelo\Permissao;
use templates\Igreja;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['COTACAO_COMPRA']);
    if (Aut::temPermissao(Aut::$modulos['COTACAO_COMPRA'], Permissao::REWRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }

    $solicitante = ($_GET['solicitante'] == '' || is_null($_GET['solicitante']) || !isset($_GET['solicitante'])) ? null : $_GET['solicitante'];
    $data_inicial = ($_GET['data_inicial'] == '' || is_null($_GET['data_inicial']) || !isset($_GET['data_inicial'])) ? null : \bd\Formatos::dataHoraBd($_GET['data_inicial'] . ' 00:00:00');
    $data_final = ($_GET['data_final'] == '' || is_null($_GET['data_final']) || !isset($_GET['data_final'])) ? null : \bd\Formatos::dataHoraBd($_GET['data_final'] . ' 23:59:59');

    $retorno = Compra::seleciona($solicitante, $data_inicial, $data_final, 'P');
    $situacoes = Compra::SITUACAO;

    include "pesquisa.html.php";
} catch (Exception $e) {
    Igreja::erro($e);
}