<?php

use modelo\Compra;
use modelo\CompraItem;
use modelo\CategoriasFinanceira;
use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], modelo\Permissao::WRITE);

    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_POST["id"]) && $_POST["id"] != "") ? $_POST["id"] : null;
    $retorno = new Compra($id);

    $retorno->setDtSolicitacao((isset($_POST["data_solicitacao"]) && $_POST["data_solicitacao"] != '') ? $_POST["data_solicitacao"] : null);
    $retorno->setJustificativa((isset($_POST["justificativa"]) && $_POST["justificativa"] != '') ? $_POST["justificativa"] : null);
    $retorno->setSolicitante((isset($_POST["solicitante"]) && $_POST["solicitante"] != '') ? $_POST["solicitante"] : null);
    $retorno->setCategoriaFinanceira((isset($_POST["conta"]) && $_POST["conta"] != '') ? $_POST["conta"] : null);
    $retorno->setUserId(Aut::$usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);

    $itens = null;
    if (isset($_POST['itens'])) {
        $itens = json_decode($_POST['itens'], TRUE);
    }

    $retorno->salva_solicitacao();

    if ($itens) {
        $listItens = CompraItem::seleciona($retorno->getId());
        foreach ($listItens as $l) {
            CompraItem::excluiItem($l['compras_id'], $l['produto_id']);
        }

        foreach ($itens as $item) {
            $ret_item = new CompraItem($retorno->getId(), $item['id']);
            $ret_item->setCompraId($retorno->getId());
            $ret_item->setProdutoId($item['id']);
            $ret_item->setQuantidade($item['qtde']);
            $ret_item->setUserId(Aut::$usuario->getCodigo());
            $ret_item->setEmpresaId(EMPRESA);
            $ret_item->setCreated(($ret_item->getCreated()) ? $ret_item->getCreated() : $dh_atual);
            $ret_item->salva();
        }
    }

    if (SERVIDOR != 'localhost') {
        if (is_null($id)) {
            require_once RAIZ . 'vendor/autoload.php';
            $cate = new CategoriasFinanceira($retorno->getCategoriaFinanceira());
            $presidente = Membro::getPresidenteEmpresa();
            $data = date('d/m/Y');
            $hora = date('H:i:s');
            $email_de = Aut::$usuario->getEmail();
            $nome_de = Aut::$usuario->getNome();
            if (SERVIDOR == 'hom.aiftech.com.br') {
                $email_para = 'fialvieira@gmail.com';
            } else {
                $email_para = ($cate->getResponsavel() == 'PA') ? Aut::$parametros->getEmailPastor() : $presidente['email'];
            }
            $nome_para = 'Setor Administrativo';
            $msg_erro = 'Erro ao enviar o e-mail de solicitação de compra nº ' . $retorno->getId() . '. Error: ';
            $assunto = utf8_decode('PIBB - Solicitação de compra nº ' . $retorno->getId());
            $link = SITE . 'app/cadastros/cotacoes_compras/cotacao.php?compra=' . $retorno->getId();
            $mensagemHTML = "
            <html>
                <div style='text-align:justify;width:80%'>
                  <br>
                  <p>Prezados!</p>
                  <p>Em $data às $hora, foi realizada a solicitação de compra nº " . $retorno->getId() . ", pelo Sr(a). " . $nome_de . ".</p>
                  <p>Para analisar a solicitação clique <a style='color:#39f' href='$link' target='_blank'>neste link</a></p>
                  <p>    
                  <p style='margin-bottom:0px;padding-bottom:0px;font-weight:bold'>Atenciosamente.</p>
                </div>
            </html>
        ";
            enviaEmail($assunto, $mensagemHTML, $email_de, $nome_de, $email_para, $nome_para, $msg_erro);
        }
    }

    $ret = [
        "erro" => false,
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}