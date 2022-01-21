<?php

use bd\Formatos;
use modelo\Dom;
use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $igs_ants = explode(',', $_GET["ig_ant"]);
    $deps_int = explode(',', $_GET["deps_int"]);
    $dons = explode(',', $_GET['dons']);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Membro($id);
    $end_id = (isset($_GET['end_id']) && ($_GET['end_id'] !== '') && ($_GET['end_id'] !== 'undefined')) ? $_GET['end_id'] : null;
    $cargs_deps = (isset($_GET['carg_dep']) && ($_GET['carg_dep'] !== '') && ($_GET['carg_dep'] !== 'undefined')) ? json_decode($_GET["carg_dep"],
        true) : null;
    $cargos_deps_op = (isset($_GET['cargos_deps_op']) && ($_GET['cargos_deps_op'] !== '') && ($_GET['cargos_deps_op'] !== 'undefined')) ? $_GET['cargos_deps_op'] : null;
    //---> Dados para log
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->setLocalId((isset($_GET["locais"]) && $_GET["locais"] != "") ? $_GET["locais"] : null);
    $ajustado = (isset($_GET["ajustado"]) && $_GET["ajustado"] != "") ? boolval($_GET["ajustado"]) : null;
    if (boolval($_GET["ajustado"])) {
        $ajustado = true;
    } else {
        $ajustado = false;
    }
    //<---
    //---> Verifica se é para gravar endereço
    $retorno->setEnderecosId($end_id);
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
        $retorno->setEnderecosId($end->getId());
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
            $retorno->setEnderecosId($end->getId());
        }
    }
    //<---
    $retorno->setFrequencia((isset($_GET["frequencia"]) && $_GET["frequencia"] != "") ? $_GET["frequencia"] : null);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setSexo((isset($_GET["sexo"]) && $_GET["sexo"] != "") ? $_GET["sexo"] : null);
    $retorno->setDatanascimento((isset($_GET["datanascimento"]) && $_GET["datanascimento"] != "") ? $_GET["datanascimento"] : null);
    $retorno->setNaturalidade((isset($_GET["naturalidade"]) && $_GET["naturalidade"] != "") ? $_GET["naturalidade"] : null);
    $retorno->setEstadoId((isset($_GET["estado_id"]) && $_GET["estado_id"] != "") ? $_GET["estado_id"] : null);
    $retorno->setEstadocivil((isset($_GET["estadocivil"]) && $_GET["estadocivil"] != "") ? $_GET["estadocivil"] : null);
    $retorno->setDataCasamento((isset($_GET["data_casamento"]) && $_GET["data_casamento"] != "") ? $_GET["data_casamento"] : null);
    $retorno->setLatitude((isset($_GET["latitude"]) && $_GET["latitude"] != "") ? $_GET["latitude"] : null);
    $retorno->setLongitude((isset($_GET["longitude"]) && $_GET["longitude"] != "") ? $_GET["longitude"] : null);
    $retorno->setRg((isset($_GET["rg"]) && $_GET["rg"] != "") ? $_GET["rg"] : null);
    $retorno->setOrgaoEmissor((isset($_GET["orgao_emissor"]) && $_GET["orgao_emissor"] != "") ? $_GET["orgao_emissor"] : null);
    $retorno->setDataExpedicao((isset($_GET["data_expedicao"]) && $_GET["data_expedicao"] != "") ? $_GET["data_expedicao"] : null);
    $retorno->setCpf((isset($_GET["cpf"]) && $_GET["cpf"] != "") ? Formatos::cpfBd($_GET["cpf"]) : null);
    $retorno->setEmail((isset($_GET["email"]) && $_GET["email"] != "") ? $_GET["email"] : null);
    $retorno->setFone((isset($_GET["fone"]) && $_GET["fone"] != "") ? Formatos::telefoneBd($_GET["fone"]) : null);
    $retorno->setCel((isset($_GET["cel"]) && $_GET["cel"] != "") ? $_GET["cel"] : null);
    $retorno->setEscolaridadeId((isset($_GET["escolaridade_id"]) && $_GET["escolaridade_id"] != "") ? $_GET["escolaridade_id"] : null);
    $retorno->setProfissaoId((isset($_GET["profissao_id"]) && $_GET["profissao_id"] != "") ? $_GET["profissao_id"] : null);
    $retorno->setEmpresa((isset($_GET["empresa"]) && $_GET["empresa"] != "") ? $_GET["empresa"] : null);
    $retorno->setDatabatismo((isset($_GET["databatismo"]) && $_GET["databatismo"] != "") ? $_GET["databatismo"] : null);
    $retorno->setIgrejabatismo((isset($_GET["igrejabatismo"]) && $_GET["igrejabatismo"] != "") ? $_GET["igrejabatismo"] : null);
    $retorno->setPastorbatismo((isset($_GET["pastorbatismo"]) && $_GET["pastorbatismo"] != "") ? $_GET["pastorbatismo"] : null);
    $retorno->setAtaBatismo((isset($_GET["ata_batismo"]) && $_GET["ata_batismo"] != "") ? $_GET["ata_batismo"] : null);
    $retorno->setUltimaigreja((isset($_GET["ultimaigreja"]) && $_GET["ultimaigreja"] != "") ? $_GET["ultimaigreja"] : null);
    $retorno->setDatamembro((isset($_GET["datamembro"]) && $_GET["datamembro"] != "") ? $_GET["datamembro"] : null);
    $retorno->setComplemento((isset($_GET["complemento"]) && $_GET["complemento"] != "") ? strtoupper($_GET["complemento"]) : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? strtoupper($_GET["numero"]) : null);
    $retorno->setTextos((isset($_GET["sel_txts"]) && $_GET["sel_txts"] != "") ? $_GET["sel_txts"] : null);
   /* $retorno->setCargoId(null);*/

    $retorno->setTipo((isset($_GET["tipo"]) && $_GET["tipo"] != "") ? $_GET["tipo"] : null);
    $retorno->salva();
    //--->Salvar igrejas anteriores
    foreach ($igs_ants as $key => $value) {
        if (empty($value)) {
            unset($igs_ants[$key]);
        }
    }

    if (!empty($igs_ants) > 0) {
        $retorno->excluiMembroEmpresa();
        foreach ($igs_ants as $ig) {
            $retorno->setIgrejasAnteriores($ig);
            $retorno->gravaMembroEmpresa();
        }
    }
    //<---
    //--->Salvar dons em pessoa_dons
    foreach ($dons as $key => $value) {
        if (empty($value)) {
            unset($dons[$key]);
        }
    }

    if (!empty($dons) > 0) {
        Dom::excluiPessoaDons($retorno->getId(), EMPRESA);
        foreach ($dons as $dom) {
            \modelo\Dom::gravaPessoaDons($retorno->getId(), $dom, EMPRESA, $usuario->getCodigo(), $dh_atual, $dh_atual);
        }
    }
    //<---
    //--->Salvar departamentos de interesse
    foreach ($deps_int as $key => $value) {
        if (empty($value)) {
            unset($deps_int[$key]);
        }
    }

    if (!empty($deps_int) > 0) {
        $retorno->excluiMembroDepartamento();
        foreach ($deps_int as $di) {
            $retorno->setDepartamentosInteresse($di);
            $retorno->gravaMembroDepartamento();
        }
    }
    //<---
    //--->Salvar cargos e departamentos ocupados dentro da instituição
    if ($cargos_deps_op == 'I') {
        if (!empty($cargs_deps) > 0) {
            $retorno->excluiCargosDepartamentos();
            foreach ($cargs_deps as $k => $v) {
                $retorno->gravaCargoDepartamento($v["cargo_id"], $v["departamento_id"], $v["periodo"], $v["ativo"]);
            }
        }
    }
    //<---
    //--->Salvar dados para full text search
    $retorno->setFullText();
    //<---
    $ret = [
        "erro" => false,
        "id" => $retorno->getId()
    ];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);