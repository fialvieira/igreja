<?php
    use modelo\MovimentacaoItem;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new MovimentacaoItem($id);
        $retorno->setQuantidade((isset($_GET["quantidade"]) && $_GET["quantidade"] != "")? $_GET["quantidade"] : null);
        $retorno->setDevolvido((isset($_GET["devolvido"]) && $_GET["devolvido"] != "")? $_GET["devolvido"] : null);
        $retorno->setMembroId((isset($_GET["membro_id"]) && $_GET["membro_id"] != "")? $_GET["membro_id"] : null);
        $retorno->setItemId((isset($_GET["item_id"]) && $_GET["item_id"] != "")? $_GET["item_id"] : null);
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