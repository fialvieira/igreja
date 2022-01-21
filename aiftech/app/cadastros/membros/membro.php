<?php

use modelo\Ata;

include "../../../def.php";

try {
    /*Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);*/
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Membro($id);
    $estados = \modelo\Estado::seleciona();
    $escolaridades = \modelo\Escolaridade::seleciona();
    $profissoes = \modelo\Profissao::seleciona();
    $cargos = \modelo\Cargo::seleciona();
    $filtro = explode(",", $id);
    $dons = \modelo\Dom::seleciona('S');
    $frequencias = \modelo\Frequencia::seleciona();
    $locais = \modelo\Local::seleciona('S');
    $igrejas = \modelo\Empresa::listaIgrejas();
    $ig_ant = $retorno->getIgrejasAnteriores();
    $pastores = \modelo\Pastor::listaPastores();
    $dom_membro = \modelo\Dom::selecionaPorUsuarioEmpresa($id, null);
    $tp_salvamento = (is_null($id)) ? 'I' : 'A';
    $dep_interesse = \modelo\Departamento::seleciona('S', null, 'S');
    $deps = $retorno->getDepartamentosInteresse();
    $cargos_ocupados = $retorno->getCargos();
    $pastor = new \modelo\Pastor($retorno->getPastorbatismo());
    $igreja_batismo = new \modelo\Empresa($retorno->getIgrejabatismo());
    $ultima_igreja = new \modelo\Empresa($retorno->getUltimaigreja());

    if (!is_null($id)) {
        $nome_arr = explode(' ', $retorno->getNome());
        $nome_ajustado = $nome_arr[0] . '%';
        $atas = Ata::seleciona(tiraAcentos($nome_ajustado));
    }
    if (empty($cargos_ocupados)) {
        $flag_cargos_ocupados = false;
    } else {
        $flag_cargos_ocupados = true;
    }
    if ($retorno->getEnderecosId() != '') {
        $end = new \modelo\Endereco($retorno->getEnderecosId());
        $end_flag = true;
    } else {
        $end_flag = false;
    }

    $foto = $retorno->getImagem();

    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";
    include "membro.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}