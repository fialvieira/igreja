<?php
use modelo\Ata;
use modelo\Documento;
use modelo\Membro;
use modelo\MovimentacaoMembro;
include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::VIEWER);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Membro($id);
    $atas = [];
    if(!is_null($id)){
        $nome_arr = explode(' ', $retorno->getNome());
        $nome_ajustado = $nome_arr[0] . '%';
        $atas = Ata::seleciona(tiraAcentos($nome_ajustado));
    }
    $cartas = Documento::seleciona(tiraAcentos($retorno->getNome()));
    $tipo_mov_membro = MovimentacaoMembro::listaTiposMovimentacao();
    $pastores = \modelo\Pastor::listaPastores();
    $igrejas = \modelo\Empresa::listaIgrejas();
    $manual = RAIZ."docs/manuais/Cadastro_Membros_Movimentacao.pdf";
    include "movimentacao_membro.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}