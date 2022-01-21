<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $arquivos = null;

    if ($_GET["cancela"] == '' || is_null($_GET["cancela"]) || !isset($_GET["cancela"])) {
        $codigo = (isset($_POST["codigo"]) && $_POST["codigo"] != "") ? $_POST["codigo"] : null;
    } else {
        $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    }

    $retorno = new MovimentacaoFinanceira($codigo);

    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    if ($_GET["cancela"] == '' || is_null($_GET["cancela"]) || !isset($_GET["cancela"])) {
        $retorno->setTipo((isset($_POST["tipo"]) && $_POST["tipo"] != "") ? $_POST["tipo"] : null);
        $retorno->setData((isset($_POST["data"]) && $_POST["data"] != "") ? $_POST["data"] : null);
        $retorno->setDescricao((isset($_POST["descricao"]) && $_POST["descricao"] != "") ? $_POST["descricao"] : null);
        $retorno->setDocumento((isset($_POST["documento"]) && $_POST["documento"] != "") ? $_POST["documento"] : null);
        $retorno->setCategoriaFinanceira((isset($_POST["conta"]) && $_POST["conta"] != "") ? $_POST["conta"] : null);
        $retorno->setValor((isset($_POST["valor"]) && $_POST["valor"] != "") ? $_POST["valor"] : null);
        $retorno->setCentroCusto((isset($_POST["centro_custo"]) && $_POST["centro_custo"] != "") ? $_POST["centro_custo"] : null);
        $retorno->setMembroId((isset($_POST["contribuinte"]) && $_POST["contribuinte"] != "") ? $_POST["contribuinte"] : null);
        $retorno->setContasFinanceiraId((isset($_POST["conta_financeira"]) && $_POST["conta_financeira"] != "") ? $_POST["conta_financeira"] : null);
        if (isset($_POST['arquivos'])) {
            $arquivos = json_decode($_POST['arquivos'], TRUE);
        }
        $retorno->salva();
    } else {
        $retorno->setCancelado((isset($_GET["cancela"]) && $_GET["cancela"] != "") ? $_GET["cancela"] : null);
        $retorno->setJustifica_cancela((isset($_GET["justificativa"]) && $_GET["justificativa"] != "") ? $_GET["justificativa"] : null);
        $retorno->setUser_cancela($usuario->getCodigo());
        $retorno->cancelaMovimentacaoFinanceira();
    }

    if ($arquivos) {
        foreach ($arquivos as $arquivo) {
            $retorno->salvaArquivo($arquivo['path'], $arquivo['nome']);
        }
    }

    $ret = ["erro" => false];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}