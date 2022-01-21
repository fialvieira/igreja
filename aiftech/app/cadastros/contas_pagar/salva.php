<?php

use modelo\MovimentacaoFinanceira;
use modelo\Compra;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_PAGAR'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $codigo = (isset($_POST["codigo"]) && $_POST["codigo"] != "") ? $_POST["codigo"] : null;
    $arquivo = (isset($_POST["arquivo_nota"]) && $_POST["arquivo_nota"] != "") ? $_POST["arquivo_nota"] : null;
    $path = null;
    if (!is_null($arquivo)) {
        $arquivo = json_decode($arquivo);
        $path = $arquivo[0]->path;
    }
    $retorno = new Compra($codigo);
    if (is_null($codigo)) {
        $retorno->setId((isset($_POST["codigo"]) && $_POST["codigo"] != "") ? $_POST["codigo"] : null);
    }
    $retorno->setDtNotaFiscal((isset($_POST["data_nota"]) && $_POST["data_nota"] != "") ? $_POST["data_nota"] : null);
    $retorno->setNotaFiscal((isset($_POST["numero_nota"]) && $_POST["numero_nota"] != "") ? $_POST["numero_nota"] : null);
    $retorno->setValorNotaFiscal((isset($_POST["valor_nota"]) && $_POST["valor_nota"] != "") ? $_POST["valor_nota"] : null);
    $retorno->setParcelasNota((isset($_POST["parcelas_nota"]) && $_POST["parcelas_nota"] != "") ? $_POST["parcelas_nota"] : null);
    $retorno->setMeiosPagamento((isset($_POST["meios_pagamentos"]) && $_POST["meios_pagamentos"] != "") ? $_POST["meios_pagamentos"] : null);
    $retorno->setObservacoes((isset($_POST["observacao"]) && $_POST["observacao"] != "") ? $_POST["observacao"] : null);
    $retorno->setPathNota($path);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salvaDadosNota();

    $ret = ["erro" => false];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}