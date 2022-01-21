<?php

use modelo\Produto;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PRODUTOS']);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = Produto::selecionaFornecedoresAtivos($id);
    include "detalhes.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}