<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO']);
    if (Aut::temPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }
    $manual = RAIZ . "docs/manuais/Cadastro_Planejamento_Orcamentario.pdf";
    
    $anos = \modelo\Orcamento::getAnosAtivos();
    $year = date('Y');
    $meses = mesPorExtenso();

    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}