<?php

use modelo\Permissao;

include "../../../def.php";
try {
    $retorno = Permissao::usuariosPermissoes();

    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}