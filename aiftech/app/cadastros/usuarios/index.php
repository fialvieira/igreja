<?php
include "../../../def.php";

try {
    $u = unserialize($_SESSION['usuario']);
    
    if(!Aut::temPerfil(Aut::PERFIL_MASTER)){
        Aut::eMembro($u->getChurch());
    }
    
    if (Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)) {
        include "index.html.php";
    } else {
        $codigo = $_GET['codigo'];
        include "troca-senha.html.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
