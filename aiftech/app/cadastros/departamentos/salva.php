<?php

use modelo\Departamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['DEPARTAMENTOS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Departamento($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setAbreviacao((isset($_GET["abreviacao"]) && $_GET["abreviacao"] != "") ? $_GET["abreviacao"] : null);
    $retorno->setTipo((isset($_GET["tipo_dep"]) && $_GET["tipo_dep"] != "") ? $_GET["tipo_dep"] : null);
    $retorno->setEleicao((isset($_GET["sel_eleicao"]) && $_GET["sel_eleicao"] != "") ? $_GET["sel_eleicao"] : null);
    $retorno->setInteresse((isset($_GET["sel_interesse"]) && $_GET["sel_interesse"] != "") ? $_GET["sel_interesse"] : null);
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