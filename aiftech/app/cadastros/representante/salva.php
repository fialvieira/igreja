<?php
    use modelo\Representante;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Representante($id);
        $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "")? $_GET["nome"] : null);
        $retorno->setEmail((isset($_GET["email"]) && $_GET["email"] != "")? $_GET["email"] : null);
        $retorno->setIdade((isset($_GET["idade"]) && $_GET["idade"] != "")? $_GET["idade"] : null);
        $retorno->setDdd((isset($_GET["ddd"]) && $_GET["ddd"] != "")? $_GET["ddd"] : null);
        $retorno->setTelefone((isset($_GET["telefone"]) && $_GET["telefone"] != "")? $_GET["telefone"] : null);
        $retorno->setTipoTelefone((isset($_GET["tipo_telefone"]) && $_GET["tipo_telefone"] != "")? $_GET["tipo_telefone"] : null);
        $retorno->setCidade((isset($_GET["cidade"]) && $_GET["cidade"] != "")? $_GET["cidade"] : null);
        $retorno->setEstado((isset($_GET["estado"]) && $_GET["estado"] != "")? $_GET["estado"] : null);
        $retorno->setClassificacao((isset($_GET["classificacao"]) && $_GET["classificacao"] != "")? $_GET["classificacao"] : null);
        $retorno->setInfoad((isset($_GET["infoad"]) && $_GET["infoad"] != "")? $_GET["infoad"] : null);
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>