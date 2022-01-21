<?php
    use modelo\Contato;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Contato($id);
        $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "")? $_GET["nome"] : null);
        $retorno->setEmail((isset($_GET["email"]) && $_GET["email"] != "")? $_GET["email"] : null);
        $retorno->setTelefone((isset($_GET["telefone"]) && $_GET["telefone"] != "")? $_GET["telefone"] : null);
        $retorno->setCongregacaoId((isset($_GET["congregacao_id"]) && $_GET["congregacao_id"] != "")? $_GET["congregacao_id"] : null);
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