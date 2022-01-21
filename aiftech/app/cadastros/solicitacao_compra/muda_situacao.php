<?php

use modelo\Compra;
use modelo\CompraItem;
use modelo\CategoriasFinanceira;
use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['SOLICITACAO_COMPRA'], modelo\Permissao::WRITE);

    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $situacao = (isset($_GET["situacao"]) && $_GET["situacao"] != "") ? $_GET["situacao"] : null;
    $retorno = new Compra($id);

    $retorno->setUserId(Aut::$usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setModified($dh_atual);
    $retorno->mudaSituacao($situacao);

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
                  <p>Em $data às $hora, foi feita a finalização da solicitação de compra nº " . $retorno->getId() . ", pelo Sr(a). " . $nome_de . ".</p>
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
        "erro" => false
        ,"mensagem" => 'Situação alterada com sucesso.'
    ];
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = [
        "erro" => true
        ,"mensagem" => $e->getMessage()
    ];
    echo json_encode($ret);
}