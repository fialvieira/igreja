<?php

use modelo\Associacao;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['ASSOCIACOES'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Associacao($id);
    $retorno->setSigla((isset($_GET["sigla"]) && $_GET["sigla"] != "") ? $_GET["sigla"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);