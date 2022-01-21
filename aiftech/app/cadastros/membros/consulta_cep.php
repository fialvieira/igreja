<?php

use bd\Formatos;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS']);
    if (isset($_GET['cep']) && $_GET['cep'] != "") {
        $cep = Formatos::cepBd($_GET["cep"]);
    } else {
        $cep = null;
    }

    $endereco = \modelo\Endereco::selecionaPorCepBd($cep);

    if (empty($endereco)) {
        $endereco_json = \modelo\Endereco::selecionaPorCepWs($cep);
    } else {
        $endereco_json = json_encode($endereco);
    }
    echo $endereco_json;
} catch (\Exception $e) {
    $ret = [
        'erro' => true,
        'msg' => $e->getMessage()
    ];
    echo json_encode($ret);
}