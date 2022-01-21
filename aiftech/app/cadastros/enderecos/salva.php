<?php
    use modelo\Endereco;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Endereco($id);
        $retorno->setLogradouro((isset($_GET["logradouro"]) && $_GET["logradouro"] != "")? $_GET["logradouro"] : null);
        $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "")? $_GET["numero"] : null);
        $retorno->setComplemento((isset($_GET["complemento"]) && $_GET["complemento"] != "")? $_GET["complemento"] : null);
        $retorno->setBairro((isset($_GET["bairro"]) && $_GET["bairro"] != "")? $_GET["bairro"] : null);
        $retorno->setCep((isset($_GET["cep"]) && $_GET["cep"] != "")? $_GET["cep"] : null);
        $retorno->setCidade((isset($_GET["cidade"]) && $_GET["cidade"] != "")? $_GET["cidade"] : null);
        $retorno->setEstadoId((isset($_GET["estado_id"]) && $_GET["estado_id"] != "")? $_GET["estado_id"] : null);
        $retorno->setMembroId((isset($_GET["membro_id"]) && $_GET["membro_id"] != "")? $_GET["membro_id"] : null);
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