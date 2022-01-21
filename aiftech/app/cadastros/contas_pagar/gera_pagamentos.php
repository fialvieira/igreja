<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CONTAS_PAGAR'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $parcelas = $_GET['n_parcelas'];

    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $codigo_compra = (isset($_GET["codigo_compra"]) && $_GET["codigo_compra"] != "") ? $_GET["codigo_compra"] : null;

    if (isset($_GET["cancela"]) || $_GET["cancela"] != '' || !is_null($_GET["cancela"])) {
        $retorno = new MovimentacaoFinanceira($codigo);
        $retorno->setCancelado((isset($_GET["cancela"]) && $_GET["cancela"] != "") ? $_GET["cancela"] : null);
        $retorno->setJustifica_cancela((isset($_GET["justificativa"]) && $_GET["justificativa"] != "") ? $_GET["justificativa"] : null);
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->setUser_cancela($usuario->getCodigo());
        $retorno->cancelaMovimentacaoFinanceira();
    } else {
        $data_parametro = (isset($_GET["data"]) && $_GET["data"] != "") ? $_GET["data"] : null;
        if (is_null($data_parametro)) {
            throw new Exception('O parâmetro de DATA não deve ser nulo');
        }
        $data_array = explode('/', $data_parametro);
        $data = new DateTime();
        $data->setDate($data_array[2], $data_array[1], $data_array[0]);
        for ($i = 1; $i <= $parcelas; $i++) {
            $retorno = new MovimentacaoFinanceira($codigo);
            $retorno->setTipo((isset($_GET["tipo"]) && $_GET["tipo"] != "") ? $_GET["tipo"] : null);
            $retorno->setData($data->format('Y-m-d'));
            $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
            $retorno->setDocumento((isset($_GET["documento"]) && $_GET["documento"] != "") ? $_GET["documento"] : null);
            $retorno->setCategoriaFinanceira((isset($_GET["conta"]) && $_GET["conta"] != "") ? $_GET["conta"] : null);
            $retorno->setValor((isset($_GET["valor"]) && $_GET["valor"] != "") ? $_GET["valor"] : null);
            $retorno->setCentroCusto((isset($_GET["centro_custo"]) && $_GET["centro_custo"] != "") ? $_GET["centro_custo"] : null);
            $retorno->setMembroId((isset($_GET["contribuinte"]) && $_GET["contribuinte"] != "") ? $_GET["contribuinte"] : null);
            $retorno->setContasFinanceiraId((isset($_GET["conta_financeira"]) && $_GET["conta_financeira"] != "") ? $_GET["conta_financeira"] : null);
            $retorno->setComprasId((isset($_GET["codigo_compra"]) && $_GET["codigo_compra"] != "") ? $_GET["codigo_compra"] : null);
            $retorno->setEmpresaId(EMPRESA);
            $retorno->setUserId($usuario->getCodigo());
            $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
            $retorno->setModified($dh_atual);
            $retorno->salva();
            $data->add(DateInterval::createFromDateString('1 month'));
        }
    }

    $movimentacao = MovimentacaoFinanceira::listaMovimentacoesPorCompra($codigo_compra, 'S', 'N');
    include 'movimentacao_financeira_pesquisa.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}