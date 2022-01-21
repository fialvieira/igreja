<?php

include "../../../def.php";

try {
    Aut::filtraPerfil(Aut::PERFIL_MASTER);
    $retorno = new \modelo\Parametros();
    
    include "parametros.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}