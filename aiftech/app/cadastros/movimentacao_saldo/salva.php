<?php

use modelo\MovimentacaoSaldo;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $retorno = new MovimentacaoSaldo(null);

    $retorno->setData((isset($_GET['data']) && ($_GET['data'] !== '') && ($_GET['data'] !== 'undefined')) ? $_GET['data'] : null);
    $retorno->setDescricao((isset($_GET['descricao']) && ($_GET['descricao'] !== '') && ($_GET['descricao'] !== 'undefined')) ? $_GET['descricao'] : null);
    $retorno->setContasFinanceiraOrigemId((isset($_GET['conta_origem']) && ($_GET['conta_origem'] !== '') && ($_GET['conta_origem'] !== 'undefined')) ? $_GET['conta_origem'] : null);
    $retorno->setContasFinanceiraDestinoId((isset($_GET['conta_destino']) && ($_GET['conta_destino'] !== '') && ($_GET['conta_destino'] !== 'undefined')) ? $_GET['conta_destino'] : null);
    $retorno->setValor((isset($_GET['valor']) && ($_GET['valor'] !== '') && ($_GET['valor'] !== 'undefined')) ? $_GET['valor'] : null);
    $retorno->setSaldoOrigem((isset($_GET['saldo']) && ($_GET['saldo'] !== '') && ($_GET['saldo'] !== 'undefined')) ? $_GET['saldo'] : null);
    $retorno->setSaldoDestino((isset($_GET['saldo_destino']) && ($_GET['saldo_destino'] !== '') && ($_GET['saldo_destino'] !== 'undefined')) ? $_GET['saldo_destino'] : null);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);