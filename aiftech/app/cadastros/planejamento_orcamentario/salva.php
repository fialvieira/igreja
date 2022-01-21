<?php

use modelo\Orcamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $replicar_valor = filter_var($_GET["replicar_valor"], FILTER_VALIDATE_BOOLEAN);

    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "") ? $_GET["codigo"] : null;
    $retorno = new Orcamento($codigo);
    $retorno->setAno((isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : $retorno->getAno());
    $retorno->setMes((isset($_GET["mes"]) && $_GET["mes"] != "") ? $_GET["mes"] : $retorno->getMes());
    $retorno->setCategoriaId((isset($_GET["conta"]) && $_GET["conta"] != "") ? $_GET["conta"] : $retorno->getCategoriaId());
    $retorno->setValorPrevisto((isset($_GET["valor_previsto"]) && $_GET["valor_previsto"] != "") ? $_GET["valor_previsto"] : null);

    $retorno->setEmpresaId(EMPRESA);
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);
    $retorno->salva();

    if ($replicar_valor) {
        $lista = Orcamento::listaOrcamentos($retorno->getAno(), $retorno->getMes(), $retorno->getCategoriaId());

        foreach ($lista as $l) {
            if ($l['ano'] == $retorno->getAno() && $l['mes'] == $retorno->getMes()) {
                continue;
            } else {
                $replica = new Orcamento($l['id']);
                $replica->setValorPrevisto($retorno->getValorPrevisto());
                $replica->setEmpresaId(EMPRESA);
                $replica->setUserId($usuario->getCodigo());
                $replica->setCreated(($replica->getCreated()) ? $replica->getCreated() : $dh_atual);
                $replica->setModified($dh_atual);
                $replica->salva();
            }
        }
    }

    $ret = ["erro" => false];
} catch (\Exception $e) {
    $msg = $e->getMessage();
    if (strpos($msg, 'Duplicate') !== false) {
        $msg = 'Planejamento para o ano, mês e conta informados já existe.';
    }
    $ret = ["erro" => true, "mensagem" => $msg];
}
echo json_encode($ret);
