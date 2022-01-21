<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['ATAS'], \modelo\Permissao::WRITE);

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Ata($id);

    $manual = RAIZ . "docs/manuais/Cadastro_Atas.pdf";
    $ata = null;
    $arquivos = [];
    if (!is_null($retorno->getId())) {
        $ata = modelo\Ata::selecionaArquivos($id, 'S');
        $arquivos = modelo\Ata::selecionaArquivos($id, 'N');
    }
    $tipos = \modelo\AtaTipo::seleciona('S');
    if ($retorno->getFinalizado() != 'S') {
        $presidente = modelo\Membro::getMembroByCargo('P');
    } else {
        $presidente = modelo\Membro::getCargoAtasByMembro('P',$retorno->getPresidencia(),substr($retorno->getData(), 6, 4));
    }
    $secretario = modelo\Membro::getMembroByCargo('S');
    $membros = modelo\Membro::atasMembrosSeleciona('S');
    $arrMembroCargos = [];
    foreach ($membros as $membro) {
        $arrMembroCargos[$membro['id']] [] = [
            'codigo' => $membro['id'],
            'nome' => $membro['nome'],
            'cargo' => $membro['cargo_nome'],
            'departamento' => $membro['dep_nome']
        ];
    }
    foreach ($presidente as $p) {
        $eh_presidente = (array_search(Aut::$usuario->getCpf(), $p)) ? true : false;
    }

    $empresa = new modelo\Empresa(EMPRESA);
    $endereco = new modelo\Endereco($empresa->getEndereco());
    $tx_endereco = $endereco->getLogradouro() . ', nº' . $empresa->getNumero() . ', ';
    if ($empresa->getComplemento()) {
        $tx_endereco .= $empresa->getComplemento() . ', ';
    }
    $tx_endereco .= $endereco->getBairro() . ', ' . $endereco->getLocalidade() . ', ' . $endereco->getEstadoSigla();

    include "ata.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}