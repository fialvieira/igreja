<?php

use modelo\Parametros;

include "../../../def.php";
try {
    Aut::filtraPerfil(Aut::PERFIL_MASTER);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    
    $retorno = new Parametros();
    
    $retorno->setId((isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null);
    $retorno->setIdadeQuorum((isset($_GET["idade_quorum"]) && $_GET["idade_quorum"] != "") ? $_GET["idade_quorum"] : null);
    $retorno->setIdPresidentesAta((isset($_GET["id_presidentes_ata"]) && $_GET["id_presidentes_ata"] != "") ? $_GET["id_presidentes_ata"] : null);
    $retorno->setIdSecretariosAta((isset($_GET["id_secretarios_ata"]) && $_GET["id_secretarios_ata"] != "") ? $_GET["id_secretarios_ata"] : null);
    $retorno->setEmailAdministrativo((isset($_GET["email_administrativo"]) && $_GET["email_administrativo"] != "") ? $_GET["email_administrativo"] : null);

    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();
    
    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);