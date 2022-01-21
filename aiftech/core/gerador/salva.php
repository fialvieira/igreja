<?php

use gerador\TabelasAuto;

include "../../def.php";

try {
    $tabela = $_GET['tabela'];
    $tabelas = new TabelasAuto($tabela);
    $r = $tabelas->getTabela();
    foreach ($r as $campo) {
        $campo['VALOR'] = ($_GET[$campo['CAMPO']]) ? $_GET[$campo['CAMPO']] : '';
        $campos[] = $campo;
    }

    TabelasAuto::salva($campos);
    $ret = ['erro' => false];
} catch (\Exception $e) {
    $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);
