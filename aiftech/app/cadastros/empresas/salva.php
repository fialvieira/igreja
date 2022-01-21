<?php

use modelo\Empresa;
use bd\Formatos;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['IGREJAS'], \modelo\Permissao::WRITE);

    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Empresa($id);
    if (isset($_GET["ativo"])) {
        $retorno->setAtivo((isset($_GET["ativo"]) && $_GET["ativo"] != "") ? $_GET["ativo"] : $retorno->getAtivo());
        $retorno->salva();
        $ret = ["erro" => false];
        echo json_encode($ret);
        exit;
    }

    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : $retorno->getNome());
    $retorno->setAbreviacao((isset($_GET["abreviacao"]) && $_GET["abreviacao"] != "") ? $_GET["abreviacao"] : null);
    $retorno->setCnpj((isset($_GET["cnpj"]) && $_GET["cnpj"] != "") ? $_GET["cnpj"] : $retorno->getCnpj());
    $retorno->setTelefone((isset($_GET["telefone"]) && $_GET["telefone"] != "") ? $_GET["telefone"] : $retorno->getTelefone());
    $retorno->setCelular((isset($_GET["celular"]) && $_GET["celular"] != "") ? $_GET["celular"] : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null);
    $retorno->setComplemento((isset($_GET["complemento"]) && $_GET["complemento"] != "") ? $_GET["complemento"] : null);
    $retorno->setEmail((isset($_GET["email"]) && $_GET["email"] != "") ? $_GET["email"] : null);
    $retorno->setAssociacaoId((isset($_GET["associacao"]) && $_GET["associacao"] != "") ? $_GET["associacao"] : null);

    if (boolval($_GET["ajustado"])) {
        $ajustado = true;
    } else {
        $ajustado = false;
    }

//---> Verifica se é para gravar endereço
    $end_id = (isset($_GET['end_id']) && $_GET['end_id'] !== '' && $_GET['end_id'] !== 'undefined') ? $_GET['end_id'] : null;

    $retorno->setEndereco($end_id);
    if (is_null($end_id) && (isset($_GET["cep_real"]) && $_GET["cep_real"] != "")) {
        $end = new \modelo\Endereco($end_id);
        $end->setCep((isset($_GET["cep_real"]) && $_GET["cep_real"] != "") ? $_GET["cep_real"] : null);
        $end->setBairro((isset($_GET["bairro"]) && $_GET["bairro"] != "") ? strtoupper(tiraAcentos($_GET["bairro"])) : null);
        $end->setLogradouro((isset($_GET["logradouro"]) && $_GET["logradouro"] != "") ? strtoupper(tiraAcentos($_GET["logradouro"])) : null);
        $end->setLocalidade((isset($_GET["localidade"]) && $_GET["localidade"] != "") ? strtoupper(tiraAcentos($_GET["localidade"])) : null);
        $end->setEstado((isset($_GET["uf"]) && $_GET["uf"] != "") ? $_GET["uf"] : null);
        $end->setNovo('N');
        $end->setUserId($usuario->getCodigo());
        $end->setCreated(($end->getCreated()) ? $end->getCreated() : $dh_atual);
        $end->setModified($dh_atual);
        $end->salva();
        $retorno->setEndereco($end->getId());
    } else {
        if ($ajustado) {
            $end = new \modelo\Endereco(null);
            $end->setCep((isset($_GET["cep_real"]) && $_GET["cep_real"] != "") ? Formatos::cepBd($_GET["cep_real"]) : null);
            $end->setBairro((isset($_GET["bairro"]) && $_GET["bairro"] != "") ? strtoupper(tiraAcentos($_GET["bairro"])) : null);
            $end->setLogradouro((isset($_GET["logradouro"]) && $_GET["logradouro"] != "") ? strtoupper(tiraAcentos($_GET["logradouro"])) : null);
            $end->setLocalidade((isset($_GET["localidade"]) && $_GET["localidade"] != "") ? strtoupper(tiraAcentos($_GET["localidade"])) : null);
            $end->setEstado((isset($_GET["uf"]) && $_GET["uf"] != "") ? $_GET["uf"] : null);
            $end->setNovo('S');
            $end->setUserId($usuario->getCodigo());
            $end->setCreated(($end->getCreated()) ? $end->getCreated() : $dh_atual);
            $end->setModified($dh_atual);
            $end->salva();
            $retorno->setEndereco($end->getId());
        }
    }
//<---
    $retorno->salva();
//---> Verificar se ja existe pastor e insere ou atualiza o pastor
    $existe_pastor = \modelo\Pastor::existeTitular($id);
    if (isset($_GET['pastor']) && $_GET['pastor']) {
        if (!$existe_pastor || ($_GET['pastor'] != $existe_pastor['id'])) {
            if ($existe_pastor['id']) {
                $pastor_atual = new \modelo\Pastor($existe_pastor['id']);
                $pastor_atual->setCategoria('D');
                $pastor_atual->setUserId($usuario->getCodigo());
                $pastor_atual->setCreated(($pastor_atual->getCreated()) ? $pastor_atual->getCreated() : $dh_atual);
                $pastor_atual->setModified($dh_atual);
                $pastor_atual->salva($id);
            }
            $pastor_novo = new \modelo\Pastor($_GET['pastor']);

            $pastor_novo->setCategoria('T');
            $pastor_novo->setUserId($usuario->getCodigo());
            $pastor_novo->setCreated(($pastor_novo->getCreated()) ? $pastor_novo->getCreated() : $dh_atual);
            $pastor_novo->setModified($dh_atual);
            $pastor_novo->salva($id);
        }
    } else {
        if ($existe_pastor['id']) {
            $pastor_atual = new \modelo\Pastor($existe_pastor['id']);
            $pastor_atual->setCategoria('D');
            $pastor_atual->setUserId($usuario->getCodigo());
            $pastor_atual->setCreated(($pastor_atual->getCreated()) ? $pastor_atual->getCreated() : $dh_atual);
            $pastor_atual->setModified($dh_atual);
            $pastor_atual->salva($id);
        }
    }
//<---
    $ret = ["erro" => false];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}