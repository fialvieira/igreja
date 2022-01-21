<?php

use modelo\Ata;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PASTORES']);
    $ata = (isset($_GET["ata"]) && $_GET["ata"] != "") ? $_GET["ata"] : null;
    $retorno = Ata::selecionaPorNum($ata);
    if (is_null($retorno['id'])) {
        throw new \Exception('Ata inexistente, verifique!');
    }
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);