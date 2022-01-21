<?php

use modelo\Compra;
use modelo\CompraItem;
use modelo\CompraOrcamento;
use modelo\CategoriasFinanceira;
use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['COTACAO_COMPRA'], modelo\Permissao::WRITE);

    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_POST["id"]) && $_POST["id"] != "") ? $_POST["id"] : null;
    $tipo = (isset($_POST["tipo"]) && $_POST["tipo"] != "") ? $_POST["tipo"] : null;

    $itens = null;
    if (isset($_POST['itens'])) {
        $itens = json_decode($_POST['itens'], TRUE);
    }
    $arquivos = null;
    if (isset($_POST['arquivos'])) {
        $arquivos = json_decode($_POST['arquivos'], TRUE);
    }
    $retorno = new Compra($id);
    if ($tipo == 'A') { //---->> Checa se vai salvar alterando status para enviar para aprovação
        $retorno->setAutorizador($retorno->getAutorizador());
        $retorno->setDtAutorizacao($retorno->getDtAutorizacao());
        $retorno->setObservacoes($retorno->getObservacoes());
        $retorno->setSituacao('F');
        $retorno->setUserId(Aut::$usuario->getCodigo());
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setModified($dh_atual);
        $retorno->alteraSituacao();
    }

    if ($arquivos) {
        foreach ($arquivos as $arquivo) {
            $ret_orc = new CompraOrcamento($retorno->getId(), $arquivo['fornecedor_id']);
            $ret_orc->excluiArquivo();

            $ret_orc->setCompraId($retorno->getId());
            $ret_orc->setFornecedorId($arquivo['fornecedor_id']);
            $ret_orc->setDataOrcamento(date('Y-m-d'));
            $ret_orc->setNomeArquivo($arquivo['nome_arquivo']);
            $ret_orc->setOrcamentoPath($arquivo['orcamento_path']);
            $ret_orc->setUserId(Aut::$usuario->getCodigo());
            $ret_orc->setEmpresaId(EMPRESA);
            $ret_orc->setCreated(($ret_orc->getCreated()) ? $ret_orc->getCreated() : $dh_atual);
            $ret_orc->salva();
        }
    }

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
            $ret_item->setValorUnitario($item['vl_unit']);
            $ret_item->setValorTotal($item['vl_total']);
            $ret_item->setFornecedorId($item['orcamento']);
            $ret_item->setUserId(Aut::$usuario->getCodigo());
            $ret_item->setEmpresaId(EMPRESA);
            $ret_item->setCreated(($ret_item->getCreated()) ? $ret_item->getCreated() : $dh_atual);
            $ret_item->salva();
        }
    }

    if (SERVIDOR != 'localhost') {
        if ($tipo == 'A') {
            require_once RAIZ . 'vendor/autoload.php';
            $cate = new CategoriasFinanceira($retorno->getCategoriaFinanceira());
            $presidente = Membro::getPresidenteEmpresa();

            $data = date('d/m/Y');
            $hora = date('H:i:s');
            $email_de = Aut::$usuario->getEmail();
            $nome_de = Aut::$usuario->getNome();
            $email_para = ($cate->getResponsavel() == 'PA') ? Aut::$parametros->getEmailPastor() : $presidente['email'];
            $nome_para = ($cate->getResponsavel() == 'PA') ? 'Senhor(a) Pastor(a)' : 'Senhor(a) Presidente';
            $msg_erro = 'Erro ao enviar o e-mail para aprovação de orçamentos da compra nº ' . $retorno->getId() . '. Error: ';
            $assunto = utf8_decode('PIBB - Aprovação de orçamentos da compra nº ' . $retorno->getId());
            $link = SITE . 'app/cadastros/aprovacao_pedidos/solicitacao.php?id=' . $retorno->getId();
            $mensagemHTML = "
            <html>
                <div style='text-align:justify;width:80%'>
                  <br>
                  <p>Prezado!</p>
                  <p>Em $data às $hora, foi realizada a cotação e inclusão de orçamentos para a compra nº " . $retorno->getId() . ", pelo Sr(a). " . $nome_de . ".</p>
                  <p>Para analisar os orçamentos e realizar a aprovação clique <a style='color:#39f' href='$link' target='_blank'>neste link</a></p>
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
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);