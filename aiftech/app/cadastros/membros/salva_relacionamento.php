<?php

use modelo\Relacionamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = null;
    $retorno = new Relacionamento($id);

    $tipo_relacionamento_id = (isset($_GET['tipo_relacionamento_id']) && ($_GET['tipo_relacionamento_id'] !== '') && ($_GET['tipo_relacionamento_id'] !== 'undefined')) ? $_GET['tipo_relacionamento_id'] : null;
    $parente_id = (isset($_GET['parente_id']) && ($_GET['parente_id'] !== '') && ($_GET['parente_id'] !== 'undefined')) ? $_GET['parente_id'] : null;
    $parente_base_id = (isset($_GET['parente_base_id']) && ($_GET['parente_base_id'] !== '') && ($_GET['parente_base_id'] !== 'undefined')) ? $_GET['parente_base_id'] : null;

    $retorno->setMembro2Id($parente_id);
    $retorno->setMembroId($parente_base_id);
    $retorno->setTiporelacionamentoId($tipo_relacionamento_id);

    //---> Dados para log
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    //<---
    $retorno->salva();

    if($retorno->getId() != ''){
        if($tipo_relacionamento_id == 1 || $tipo_relacionamento_id == 2){
            $n_ret = new Relacionamento(null);
            $n_ret->setTiporelacionamentoId(4);
            $n_ret->setMembroId($parente_id);
            $n_ret->setMembro2Id($parente_base_id);
            $n_ret->setEmpresaId(EMPRESA);
            $n_ret->setUserId($usuario->getCodigo());
            $n_ret->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
            $n_ret->setModified($dh_atual);
            $n_ret->salva();
        }elseif ($tipo_relacionamento_id == 3){
            $n_ret = new Relacionamento(null);
            $n_ret->setTiporelacionamentoId(3);
            $n_ret->setMembroId($parente_id);
            $n_ret->setMembro2Id($parente_base_id);
            $n_ret->setEmpresaId(EMPRESA);
            $n_ret->setUserId($usuario->getCodigo());
            $n_ret->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
            $n_ret->setModified($dh_atual);
            $n_ret->salva();
        }
    }else{
        throw new \Exception('Erro ao salvar parentesco');
    }

    $ret = [
        "erro" => false,
        "id" => $retorno->getId()
    ];

    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}