<?php
    use modelo\Calendario;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Calendario($id);
        $retorno->setDatainicio((isset($_GET["datainicio"]) && $_GET["datainicio"] != "")? $_GET["datainicio"] : null);
        $retorno->setAssunto((isset($_GET["assunto"]) && $_GET["assunto"] != "")? $_GET["assunto"] : null);
        $retorno->setDatafim((isset($_GET["datafim"]) && $_GET["datafim"] != "")? $_GET["datafim"] : null);
        $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "")? $_GET["descricao"] : null);
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setModified($dh_atual);
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setDiatodo((isset($_GET["diatodo"]) && $_GET["diatodo"] != "")? $_GET["diatodo"] : null);
        $retorno->setCor((isset($_GET["cor"]) && $_GET["cor"] != "")? $_GET["cor"] : null);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>