<?php

use modelo\Cargo;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['CARGOS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Cargo($id);

    if (isset($_GET["nome"]) && $_GET["nome"]) {
        $retorno->setNome($_GET["nome"]);
    }
    if (isset($_GET["descricao"]) && $_GET["descricao"]) {
        $retorno->setDescricao($_GET["descricao"]);
    }
    if (isset($_GET["abreviacao"]) && $_GET["abreviacao"]) {
        $retorno->setAbreviacao($_GET["abreviacao"]);
    }

    $retorno->setDepartamentos((isset($_GET["departamentos"]) && !empty($_GET["departamentos"])) ? $_GET["departamentos"] : null);

    if (isset($_GET["tipo_comissao"]) && $_GET["tipo_comissao"]) {
        $retorno->setTipoComissao($_GET["tipo_comissao"]);
    }

    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    //---> Exclui dados de assoc_departamentos_cargos por empresa_id e cargo_id
    $retorno->excluiDepartamentos();
    //<---
    //---> Adicona departamentos e cargos em assoc_departamentos_cargos
    $retorno->salvaDepartamentos();
    //<---
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
?>