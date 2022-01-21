<?php
include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['PASTORES']);
    $retorno = modelo\Pastor::existeTitular();
    if ($retorno) {
        throw new \Exception($retorno['tratamento'] . ' ' . $retorno['nome'] . ' já cadastrado como pastor títular da igreja, '
            . 'só permitido apenas um pastor títular por igreja.');
    }
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);