<?php
include "../../../def.php";

try {
    Aut::filtraAutorizacao(Aut::$modulos['BANCOS']);
    $manual = '';
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}