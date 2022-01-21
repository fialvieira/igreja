<?php

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS']);
    $manual = RAIZ . "docs/manuais/Cadastro_Membros.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}