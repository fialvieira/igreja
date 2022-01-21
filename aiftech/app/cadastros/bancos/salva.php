<?php

use modelo\Banco;

include "../../../def.php";
try {
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Banco($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null);
    $retorno->setCnpj((isset($_GET["cnpj"]) && $_GET["cnpj"] != "") ? \bd\Formatos::cnpjBd($_GET["cnpj"]) : null);
    $retorno->salva();
    $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);