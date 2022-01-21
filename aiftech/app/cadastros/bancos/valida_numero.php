<?php

use modelo\Banco;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['BANCOS']);
    $numero = (isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null;
    if(strlen($numero) > 5 && strlen($numero) <= 14){
        $retorno = Banco::selecionaPorCnpj($numero);
    }else{
        $retorno = Banco::selecionaPorNumero($numero);
    }
    if ($retorno > 0) {
        throw new \Exception('Já existe banco com o número ' . $numero);
    } else {
        $ret = [
            'valido' => true,
            'mensagem' => 'Número válido para este banco'
        ];
    }
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        'valido' => false,
        'mensagem' => $e->getMessage()
    ];
    echo json_encode($ret);
}