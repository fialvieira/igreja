<?php

use modelo\CategoriasFinanceira;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANO_CONTAS'], \modelo\Permissao::WRITE);

    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $tipo = (isset($_GET["tipo_ins_upd"]) && $_GET["tipo_ins_upd"] != "") ? $_GET["tipo_ins_upd"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new CategoriasFinanceira($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setResponsavel((isset($_GET["responsavel"]) && $_GET["responsavel"] != "") ? $_GET["responsavel"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->setTipo((isset($_GET["tipo"]) && $_GET["tipo"] != "") ? $_GET["tipo"] : null);
    $retorno->setCategoriaMae((isset($_GET["categoria_mae"]) && $_GET["categoria_mae"] != "") ? $_GET["categoria_mae"] : null);
    $retorno->setNumero((isset($_GET["numero"]) && $_GET["numero"] != "") ? $_GET["numero"] : null);
    $contas = explode(',', $_GET['contas_bancarias']);

    $retorno->salva();

    foreach ($contas as $key => $value) {
        if (empty($value)) {
            unset($contas[$key]);
        }
    }

    if (!empty($contas) > 0) {
        CategoriasFinanceira::excluiContasFinanceiras($retorno->getId());
        foreach ($contas as $conta) {
            CategoriasFinanceira::gravaContasFinanceira($conta, $retorno->getId(), $usuario->getCodigo(), $dh_atual,
                $dh_atual);
        }
    }

    $ret = [
        "erro" => false,
        "mensagem" => "Sucesso ao salvar dados",
        "tipo" => $tipo
    ];
    echo json_encode($ret);
} catch (Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage(),
        "tipo" => $tipo
    ];
    echo json_encode($ret);
}