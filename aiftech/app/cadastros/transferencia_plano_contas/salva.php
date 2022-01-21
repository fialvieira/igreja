<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['TRANSFERENCIA_PLANO_DE_CONTAS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $lancamentos = json_decode($_POST['lancamentos']);

    foreach ($lancamentos as $lancamento) {
        $retorno = new MovimentacaoFinanceira($lancamento->codigo);
        $retorno->setCategoriaFinanceira($lancamento->categoria);
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
    }

    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
