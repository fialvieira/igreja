<?php
use modelo\Membro;
use modelo\MovimentacaoMembro;
use modelo\Ata;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_MOVIMENTACAO']);
    $membros = Membro::listaMembrosComMovimentacao();
    $tipo_movimentacao = MovimentacaoMembro::listaTiposMovimentacao();
    $atas = Ata::listaAtasDocsNumero();
    $manual = '';
    include 'index.html.php';
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}