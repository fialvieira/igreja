<?php

use modelo\MovimentacaoFinanceira;

include "../../../def.php";
try {
    $movimentacao_financeira = (isset($_GET["movimentacao_financeira"]) && $_GET["movimentacao_financeira"] != "") ? $_GET["movimentacao_financeira"] : null;
    $retorno = MovimentacaoFinanceira::selecionaArquivos($movimentacao_financeira);
    if ($retorno) {
        include "arquivos_movimento.html.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}