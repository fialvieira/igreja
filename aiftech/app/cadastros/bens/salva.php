<?php

use modelo\Bem;

include "../../../def.php";
try {
  Aut::filtraPermissao(Aut::$modulos['BENS'], \modelo\Permissao::WRITE);      
  $usuario = unserialize($_SESSION["usuario"]);
  $dh_atual = date("Y-m-d H:i:s");

  $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
  $retorno = new Bem($id);
  if (!isset($_GET["ativo"])) {
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setIdentificacao((isset($_GET["identificacao"]) && $_GET["identificacao"] != "") ? $_GET["identificacao"] : null);
    $retorno->setNumSerie((isset($_GET["num_serie"]) && $_GET["num_serie"] != "") ? $_GET["num_serie"] : null);
    $retorno->setNumAtivo((isset($_GET["num_ativo"]) && $_GET["num_ativo"] != "") ? $_GET["num_ativo"] : null);
    $retorno->setMarca((isset($_GET["marca"]) && $_GET["marca"] != "") ? $_GET["marca"] : null);
    $retorno->setModelo((isset($_GET["modelo"]) && $_GET["modelo"] != "") ? $_GET["modelo"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
    $retorno->setObservacao((isset($_GET["observacao"]) && $_GET["observacao"] != "") ? $_GET["observacao"] : null);
    $retorno->setDataCompra((isset($_GET["data_compra"]) && $_GET["data_compra"] != "") ? $_GET["data_compra"] : null);
    $retorno->setGarantia((isset($_GET["garantia"]) && $_GET["garantia"] != "") ? $_GET["garantia"] : null);
    $retorno->setValorUnitario((isset($_GET["valor_unitario"]) && $_GET["valor_unitario"] != "") ? $_GET["valor_unitario"] : null);
    $retorno->setDepartamentoId((isset($_GET["departamento_id"]) && $_GET["departamento_id"] != "") ? $_GET["departamento_id"] : null);
    $retorno->setLocalId((isset($_GET["local_id"]) && $_GET["local_id"] != "") ? $_GET["local_id"] : null);
    $retorno->setTipoBemId((isset($_GET["tipo_bem_id"]) && $_GET["tipo_bem_id"] != "") ? $_GET["tipo_bem_id"] : null);
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
  $msg = $e->getMessage();  
  if (strpos($msg, 'Duplicate') !== false) {
      if (strpos($msg, 'unq_identificacao') !== false) {
        $msg = 'Identificação ' . $retorno->getIdentificacao() . ' já existe.';
      } elseif (strpos($msg, 'unq_num_ativo') !== false) {
        $msg = 'Número do Ativo ' . $retorno->getIdentificacao() . ' já existe.';
      }
      
  }  
  $ret = ["erro" => true, "mensagem" => $msg];
}
echo json_encode($ret);
?>