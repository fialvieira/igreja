<?php

use modelo\TipoBem;

include "../../../def.php";
try {
//  Aut::filtraPermissao(Aut::$modulos['TIPO_BENS'], \modelo\Permissao::WRITE);
  $usuario = unserialize($_SESSION["usuario"]);
  $dh_atual = date("Y-m-d H:i:s");

  $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
  $retorno = new TipoBem($id);
  if (!isset($_GET["ativo"])) {
    $retorno->setNome(($_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
  } else {
    $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : $retorno->getAtivo());
  }
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
?>