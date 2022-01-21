<?php

use modelo\Pastor;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PASTORES'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Pastor($id);
    if (isset($_GET["nome"]) && $_GET["nome"]) {
        $retorno->setNome($_GET["nome"]);
    }
    if (isset($_GET["tratamento"]) && $_GET["tratamento"]) {
        $retorno->setTratamento($_GET["tratamento"]);
    }
    if (isset($_GET["ata_entrada"]) && $_GET["ata_entrada"]) {
        $retorno->setAtaEntrada($_GET["ata_entrada"]);
    }
    if (isset($_GET["dt_entrada"]) && $_GET["dt_entrada"]) {
        $retorno->setDtEntrada($_GET["dt_entrada"]);
    }
    if (isset($_GET["ata_saida"]) && $_GET["ata_saida"]) {
        $retorno->setAtaSaida($_GET["ata_saida"]);
    }
    if (isset($_GET["dt_saida"]) && $_GET["dt_saida"]) {
        $retorno->setDtSaida($_GET["dt_saida"]);
    }
    if (isset($_GET["funcao"]) && $_GET["funcao"]) {
        $retorno->setCategoria($_GET["funcao"]);
    }
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);