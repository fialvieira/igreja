<?php

use bd\Formatos;
use modelo\Fornecedor;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['FORNECEDORES'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Fornecedor($id);
    if (isset($_GET["nome_fantasia"]) && $_GET["nome_fantasia"]) {
        $retorno->setNomeFantasia($_GET["nome_fantasia"]);
    }
    if (isset($_GET["razao_social"]) && $_GET["razao_social"]) {
        $retorno->setRazaoSocial($_GET["razao_social"]);
    }
    if (isset($_GET["cnpj"]) && $_GET["cnpj"]) {
        $retorno->setCnpj($_GET["cnpj"]);
    }
    if (isset($_GET["email"]) && $_GET["email"]) {
        $retorno->setEmail($_GET["email"]);
    }
    if (isset($_GET["telefone"]) && $_GET["telefone"]) {
        $retorno->setTelefone($_GET["telefone"]);
    }
    if (isset($_GET["telefone2"]) && $_GET["telefone2"]) {
        $retorno->setTelefone2($_GET["telefone2"]);
    }

    if (isset($_GET["tipo"]) && $_GET["tipo"]) {
        $retorno->setTipo($_GET["tipo"]);
    }
    if (isset($_GET["ativo"]) && $_GET["ativo"]) {
        $retorno->setAtivo($_GET["ativo"]);
    }
    $end_id = (isset($_GET['end_id']) && ($_GET['end_id'] !== '') && ($_GET['end_id'] !== 'undefined')) ? $_GET['end_id'] : null;
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);

    //---> Verifica se é para gravar endereço
    $end = new \modelo\Endereco($end_id);
    $end->setCep((isset($_GET["cep"]) && $_GET["cep"] != "") ? Formatos::cepBd($_GET["cep"]) : null);
    $end->setBairro((isset($_GET["bairro"]) && $_GET["bairro"] != "") ? $_GET["bairro"] : null);
    $end->setLogradouro((isset($_GET["logradouro"]) && $_GET["logradouro"] != "") ? $_GET["logradouro"] : null);
    $end->setLocalidade((isset($_GET["localidade"]) && $_GET["localidade"] != "") ? $_GET["localidade"] : null);
    $end->setEstado((isset($_GET["uf"]) && $_GET["uf"] != "") ? $_GET["uf"] : null);
    $end->setUserId($usuario->getCodigo());
    $end->setCreated(($end->getCreated()) ? $end->getCreated() : $dh_atual);
    $end->setModified($dh_atual);
    $end->salva();
    //<---
    $retorno->setEnderecosId($end->getId());
    $retorno->setComplemento((isset($_GET["complemento"]) && $_GET["complemento"] != "") ? $_GET["complemento"] : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);