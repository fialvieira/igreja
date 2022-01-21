<?php
include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\MovimentacaoMembro($id);
    //---> Dados para log
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    //<---
    $retorno->setMembroId((isset($_GET["membro_id"]) && $_GET["membro_id"] != "") ? $_GET["membro_id"] : null);
    $retorno->setAtaId((isset($_GET["ata"]) && $_GET["ata"] != "") ? $_GET["ata"] : null);
    $retorno->setCartaId((isset($_GET["carta"]) && $_GET["carta"] != "") ? $_GET["carta"] : null);
    $retorno->setDataCartaRecebimento((isset($_GET["data_recebimento"]) && $_GET["data_recebimento"] != "") ? $_GET["data_recebimento"] : null);
    $retorno->setTipoMovimentacaoMembroId((isset($_GET["tipo_movimentacao"]) && $_GET["tipo_movimentacao"] != "") ? $_GET["tipo_movimentacao"] : null);
    $retorno->setObservacao((isset($_GET["observacao"]) && $_GET["observacao"] != "") ? $_GET["observacao"] : null);
    $retorno->setCartaRecebimentoPath((isset($_GET["arquivo_path"]) && $_GET["arquivo_path"] != "") ? $_GET["arquivo_path"] : null);
    $retorno->salva();
    //---> Dados para salvar a frequência em membros, caso houver correspondência entre tipo movimentação e frequência.
    $tipo_movimentacao_membro = new \modelo\TipoMovimentacaoMembros($retorno->getTipoMovimentacaoMembroId());
    $membro = new \modelo\Membro($retorno->getMembroId());
    if($tipo_movimentacao_membro->getMembrosFrequenciaId() != '' && !is_null($tipo_movimentacao_membro->getMembrosFrequenciaId())){
        $membro->setFrequencia($tipo_movimentacao_membro->getMembrosFrequenciaId());
        $membro->alteraFrequenciaMembro();
    }
    //<---
    $ret = [
        "erro" => false
    ];
} catch (\Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()
    ];
}
echo json_encode($ret);