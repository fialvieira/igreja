<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['TRANSFERENCIA_PLANO_DE_CONTAS']);
    $manual = RAIZ . "docs/manuais/Cadastro_Movimentacao_Financeira.pdf";
    $hoje = date('d/m/Y', strtotime('first day of this month'));
    $tipo = \modelo\MovimentacaoFinanceira::TIPOS;
    $lancamentos = CategoriasFinanceira::getLancamentosCategoriasMae($hoje, 'S');
    $cat_ant = '';
    foreach ($lancamentos as $lancamento) {
        if ($cat_ant != $lancamento['categoria_financeira_id']) {
            $planos [] = [
                'codigo' => $lancamento['categoria_financeira_id'],
                'num' => $lancamento['num'],
                'nome' => $lancamento['categoria'],
                'descricao' => $lancamento['num'] . ' - ' . $lancamento['categoria']
            ];
            $cat_ant = $lancamento['categoria_financeira_id'];
        }
    }
    $categorias = CategoriasFinanceira::getCategoriasFilhas('S');
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}