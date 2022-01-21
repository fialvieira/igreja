<?php

include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS_ANIVERSARIANTES']);
    $manual = '';//RAIZ."docs/manuais/Modulo_Cadastro_de_Locais.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}