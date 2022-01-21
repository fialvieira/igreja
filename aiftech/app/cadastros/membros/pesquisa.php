<?php

use modelo\Cargo;
use modelo\Dom;
use modelo\Escolaridade;
use modelo\Estado;
use modelo\Membro;
use modelo\Profissao;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS']);
    if (!isset($_GET['id']) || $_GET['id'] === '') {
        if (isset($_GET["texto"]) && $_GET["texto"] != "") {
            $texto = $_GET["texto"];
        } else {
            $texto = null;
        }
        if ($_GET['status'] !== '') {
            $status = $_GET['status'];
        } else {
            $status = null;
        }
        $retorno = Membro::seleciona($texto, $status, (is_null($status) ? 50 : null ),'modified');
        include "pesquisa.html.php";
    } else {
        $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
        $retorno = new Membro($id);
        if ($retorno) {
            $estado = new Estado($retorno->getEstadoId());
            $escolaridade = new Escolaridade($retorno->getEscolaridadeId());
            $profissao = new Profissao($retorno->getProfissaoId());
            $cargo = new Cargo($retorno->getCargoId());
            $dons = Dom::selecionaPorUsuarioEmpresa($id);
            $igreja_batismo = new \modelo\Empresa($retorno->getIgrejabatismo());
            $ultima_igreja = new \modelo\Empresa($retorno->getUltimaigreja());
            $ig_ant = $retorno->getIgrejasAnteriores();
            $pastor_batismo = new \modelo\Pastor($retorno->getPastorbatismo());
            $deps = $retorno->getDepartamentosInteresse();
            $cargos_ocupados = $retorno->getCargos();
            $parentesco = \modelo\Relacionamento::seleciona($retorno->getId());
            $parentesco = array_filter($parentesco);

            if(!empty($parentesco)){
                $flag_parentesco = true;
            }else{
                $flag_parentesco = false;
            }
            if (!empty($dons)) {
                $flag_dom = true;
                $dom = '';
                foreach ($dons as $v) {
                    $dom .= $v['nome'] . ', ';
                }
                $dom = substr_replace($dom, ' ', strlen($dom) - 2, 1);
            } else {
                $flag_dom = false;
            }
            if (!empty($ig_ant)) {
                $flag_ig_ant = true;
                $ig = '';
                foreach ($ig_ant as $v) {
                    $ig .= $v['nome'] . ', ';
                }
                $ig = substr_replace($ig, ' ', strlen($ig) - 2, 1);
            } else {
                $flag_ig_ant = false;
            }
            if (!empty($deps)) {
                $flag_deps = true;
                $di = '';
                foreach ($deps as $v) {
                    $di .= $v['nome'] . ', ';
                }
                $di = substr_replace($di, ' ', strlen($di) - 2, 1);
            } else {
                $flag_deps = false;
            }
            $foto = null;
            if (!is_null($id)) {
                $foto = $retorno->getImagem();
            }
            include 'detalhes.html.php';
        } else {
            throw new Exception('Membro não cadastrado');
        }
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}