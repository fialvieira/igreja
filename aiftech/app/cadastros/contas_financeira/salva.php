<?php

use modelo\ContasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_BANCARIAS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new ContasFinanceira($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
    $retorno->setBancoId((isset($_GET["banco_id"]) && $_GET["banco_id"] != "") ? $_GET["banco_id"] : null);
    $retorno->setAgencia((isset($_GET["agencia"]) && $_GET["agencia"] != "") ? $_GET["agencia"] : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null);
    $retorno->setVariacao((isset($_GET["variacao"]) && $_GET["variacao"] != "") ? $_GET["variacao"] : null);
    $retorno->setTipoConta((isset($_GET["tipo_conta"]) && $_GET["tipo_conta"] != "") ? $_GET["tipo_conta"] : null);
    $retorno->setTipoAplicacao((isset($_GET["tipo_aplicacao"]) && $_GET["tipo_aplicacao"] != "") ? $_GET["tipo_aplicacao"] : null);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->setSaldoInicial((isset($_GET["saldo_inicial"]) && $_GET["saldo_inicial"] != "") ? \bd\Formatos::real($_GET["saldo_inicial"]) : null);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);