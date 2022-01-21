<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['PROFISSOES']);
    $manual = RAIZ . "docs/manuais/Cadastro_Local.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}