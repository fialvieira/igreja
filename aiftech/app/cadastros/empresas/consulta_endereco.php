<?php

use bd\Formatos;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['IGREJAS']);
    if (isset($_GET['cep']) && $_GET['cep'] != "") {
        $cep = Formatos::cepBd($_GET["cep"]);
    } else {
        $cep = null;
    }
    /*$logradouro = (isset($_GET['logradouro']) && $_GET['logradouro'] != "") ? $_GET['logradouro'] : null;*/
    /*$endereco = \modelo\Endereco::selecionaEndereco($cep, $logradouro);*/
    $endereco = \modelo\Endereco::selecionaEnderecosPorCepBd($cep);
    include 'consulta_endereco.html.php';
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}