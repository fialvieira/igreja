<?php

use modelo\CentroCusto;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CENTRO_DE_CUSTO'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new CentroCusto($codigo);
    if (!isset($_GET["ativo"])) {
        $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
        $muda_principal = (isset($_GET["muda_principal"]) && $_GET["muda_principal"]) ? $_GET["muda_principal"] : null;
        $principal = (isset($_GET["principal"]) && $_GET["principal"] != "") ? $_GET["principal"] : null;
    } else {
        $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : null);
        $muda_principal = false;
    }

    $retorno->setEmpresasId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();

    if ($muda_principal === 'S') {
        $retorno->setPrincipal($principal);
        $ret = $retorno->alteraCentroPrincipal();
        if ($ret['ERRO'] != '0') {
            throw new \Exception($ret['DESC_ERRO']);
        }
    }
    
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
