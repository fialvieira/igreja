<?php
include "../../../def.php";

try {
    Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE);

//    $manual = RAIZ."docs/manuais/Cadastro_Local.pdf";
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}