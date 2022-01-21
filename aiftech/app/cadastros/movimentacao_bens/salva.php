<?php
    use modelo\MovimentacaoBem;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new MovimentacaoBem($id);
        $retorno->setTipo((isset($_GET["tipo"]) && $_GET["tipo"] != "")? $_GET["tipo"] : null);
        $retorno->setQuantidade((isset($_GET["quantidade"]) && $_GET["quantidade"] != "")? $_GET["quantidade"] : null);
        $retorno->setSaldo((isset($_GET["saldo"]) && $_GET["saldo"] != "")? $_GET["saldo"] : null);
        $retorno->setMotivo((isset($_GET["motivo"]) && $_GET["motivo"] != "")? $_GET["motivo"] : null);
        $retorno->setBemId((isset($_GET["bem_id"]) && $_GET["bem_id"] != "")? $_GET["bem_id"] : null);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>