<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PLANO_CONTAS']);
    $manual = RAIZ."docs/manuais/Cadastro_Contas.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}