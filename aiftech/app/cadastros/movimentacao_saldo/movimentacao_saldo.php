<?php

use modelo\MovimentacaoSaldo;
use modelo\ContasFinanceira;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $disabled = (is_null($codigo)) ? '' : 'disabled';
    $retorno = new MovimentacaoSaldo($codigo);
    $filtro = explode(",", $codigo);
    $tipos = MovimentacaoSaldo::TIPOS;
    $contas = ContasFinanceira::seleciona();
    include "movimentacao_saldo.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}