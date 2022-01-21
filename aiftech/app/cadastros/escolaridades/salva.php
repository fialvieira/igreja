<?php
    use modelo\Escolaridade;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Escolaridade($id);
        $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "")? $_GET["descricao"] : null);
        $retorno->setObs((isset($_GET["obs"]) && $_GET["obs"] != "")? $_GET["obs"] : null);
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>