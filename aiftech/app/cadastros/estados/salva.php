<?php
    use modelo\Estado;
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new Estado($id);
        $retorno->setSigla((isset($_GET["sigla"]) && $_GET["sigla"] != "")? $_GET["sigla"] : null);
        $retorno->setCodibge((isset($_GET["codibge"]) && $_GET["codibge"] != "")? $_GET["codibge"] : null);
        $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "")? $_GET["nome"] : null);
        $retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>