<?php
    use modelo\Church;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Church($id);
        $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "")? $_GET["nome"] : null);
        $retorno->setCnpj((isset($_GET["cnpj"]) && $_GET["cnpj"] != "")? $_GET["cnpj"] : null);
        $retorno->setTelefone((isset($_GET["telefone"]) && $_GET["telefone"] != "")? $_GET["telefone"] : null);
        $retorno->setEndereco((isset($_GET["endereco"]) && $_GET["endereco"] != "")? $_GET["endereco"] : null);
        $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "")? $_GET["numero"] : null);
        $retorno->setComplemento((isset($_GET["complemento"]) && $_GET["complemento"] != "")? $_GET["complemento"] : null);
        $retorno->setBairro((isset($_GET["bairro"]) && $_GET["bairro"] != "")? $_GET["bairro"] : null);
        $retorno->setCidade((isset($_GET["cidade"]) && $_GET["cidade"] != "")? $_GET["cidade"] : null);
        $retorno->setUf((isset($_GET["uf"]) && $_GET["uf"] != "")? $_GET["uf"] : null);
        $retorno->setEmail((isset($_GET["email"]) && $_GET["email"] != "")? $_GET["email"] : null);
        $retorno->setMatrizId((isset($_GET["matriz_id"]) && $_GET["matriz_id"] != "")? $_GET["matriz_id"] : null);
        $retorno->setTipo((isset($_GET["tipo"]) && $_GET["tipo"] != "")? $_GET["tipo"] : null);
        $retorno->setSubdomain((isset($_GET["subdomain"]) && $_GET["subdomain"] != "")? $_GET["subdomain"] : null);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>