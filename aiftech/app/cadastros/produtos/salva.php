<?php

use modelo\Produto;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PRODUTOS'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new Produto($id);
    $retorno->setNome((isset($_GET["nome"]) && $_GET["nome"] != "") ? $_GET["nome"] : null);
    $retorno->setDescricao((isset($_GET["descricao"]) && $_GET["descricao"] != "") ? $_GET["descricao"] : null);
    $retorno->setUnidadeMedida((isset($_GET["unidade_medida"]) && $_GET["unidade_medida"] != "") ? $_GET["unidade_medida"] : null);
    $retorno->setCategoria((isset($_GET["categoria"]) && $_GET["categoria"] != "") ? $_GET["categoria"] : null);
    $retorno->setTipoProdutoId((isset($_GET["tipo_produto"]) && $_GET["tipo_produto"] != "") ? $_GET["tipo_produto"] : null);
    $fornecedores = explode(',', $_GET['fornecedores']);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();

    foreach ($fornecedores as $key => $value) {
        if (empty($value)) {
            unset($fornecedores[$key]);
        }
    }

    if (!empty($fornecedores) > 0) {
        Produto::excluiFornecedores($retorno->getId());
        foreach ($fornecedores as $fornecedor) {
            Produto::gravaFornecedores($retorno->getId(), $fornecedor, $usuario->getCodigo(), $dh_atual, $dh_atual);
        }
    }

    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);