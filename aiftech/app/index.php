<?php
include "../def.php";
if (!Aut::logado()) {
    include "index.html.php";
} else {
    if (Aut::temPermissao(Aut::$modulos['ACOMPANHAMENTO_ORCAMENTO'], \modelo\Permissao::VIEWER)) ;
    include "dashboard.html.php";
}