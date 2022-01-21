<?php

include "../../def.php";
try {
    Aut::filtraLogado(Aut::PERFIL_MASTER);
    $table = new \gerador\Gerador();
    $tabelas = $table->getTabelas();
//    dd($tabelas);
    if (!$tabelas) {
        throw new \Exception('Não construiu as tabelas, verifique!');
    }
    include "index.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
