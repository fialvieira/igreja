<?php
    use modelo\Relacionamento;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Relacionamento($id);
        $retorno->setMembroId((isset($_GET["membro_id"]) && $_GET["membro_id"] != "")? $_GET["membro_id"] : null);
        $retorno->setTiporelacionamentoId((isset($_GET["tiporelacionamento_id"]) && $_GET["tiporelacionamento_id"] != "")? $_GET["tiporelacionamento_id"] : null);
        $retorno->setMembro2Id((isset($_GET["membro2_id"]) && $_GET["membro2_id"] != "")? $_GET["membro2_id"] : null);
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>