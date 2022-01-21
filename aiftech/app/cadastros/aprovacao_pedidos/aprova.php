<?php

use modelo\Compra;
use modelo\Permissao;
use modelo\Membro;
use modelo\Usuario;

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['APROVACAO_PEDIDOS'], Permissao::REWRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $solicitante_id = (isset($_GET["solicitante_id"]) && $_GET["solicitante_id"] != "") ? $_GET["solicitante_id"] : null;
    $aprova = (isset($_GET["aprova"]) && $_GET["aprova"] != "") ? $_GET["aprova"] : null;
    $observacao = (isset($_GET["observacao"]) && $_GET["observacao"] != "") ? $_GET["observacao"] : null;

    if (is_null($id) || is_null($aprova)) {
        throw new Exception('Parâmetros id / aprovação necessários');
    }

    $retorno = new Compra($id);
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setAutorizador($usuario);
    $retorno->setDtAutorizacao($dh_atual);
    $retorno->setObservacoes($observacao);
    $retorno->setSituacao($aprova);
    $retorno->setUserId(Aut::$usuario->getCodigo());
    $retorno->setModified($dh_atual);
    $retorno->alteraSituacao();

    if (SERVIDOR != 'localhost') {
        require_once RAIZ . 'vendor/autoload.php';
        /**
         * Encaminha e-mail para o solicitante
         */
        $membro_solicitante = new Membro($solicitante_id);
        $data = date('d/m/Y');
        $hora = date('H:i:s');
        $email_de = Aut::$usuario->getEmail();
        $nome_de = Aut::$usuario->getNome();
        $msg_erro = 'Erro ao enviar o e-mail de aprovação da compra nº ' . $retorno->getId() . '. Error: ';
        if ($aprova == 'A' || $aprova == 'R') {
            $email_para = $membro_solicitante->getEmail();
            $nome_para = $membro_solicitante->getNome();
            $assunto = utf8_decode('PIBB - ' . ($aprova == 'A') ? 'Aprovação' : 'Recusa' . ' da compra nº ' . $retorno->getId());
            $link = SITE . 'app/cadastros/aprovacao_pedidos/solicitacao.php?id=' . $retorno->getId();
            $texto_aprovacao = ($aprova == 'A') ? 'aprovada' : 'recusada';
            $mensagemHTML = "
            <html>
                <div style='text-align:justify;width:80%'>
                  <br>
                  <p>Prezado!</p>
                  <p>Em $data às $hora, foi $texto_aprovacao, a compra nº " . $retorno->getId() . ", pelo Sr(a). " . $nome_de . ".</p>
                  <p>Para verificar, clique <a style='color:#39f' href='$link' target='_blank'>neste link</a>.</p>
                  <p>    
                  <p style='margin-bottom:0px;padding-bottom:0px;font-weight:bold'>Atenciosamente.</p>
                </div>
            </html>";
            enviaEmail($assunto, $mensagemHTML, $email_de, $nome_de, $email_para, $nome_para, $msg_erro);
        } else {
            /**
             * Encaminha e-mail para o pessoal administrativo
             */
            if ($aprova == 'P') {
                $administrativos = Usuario::listaUsuariosPorPerfil(Usuario::STATUS_ATIVO, Usuario::ADMINISTRATIVO);
                if (count($administrativos) > 0) {
                    foreach ($administrativos as $k => $v) { //TODO Deixar o e-mail do pessoal com perfil ADMINISTRATIVO
                        $email_para = (SERVIDOR != 'localhost') ? 'fialvieira@gmail.com' : $v['email'];
                        $nome_para = (SERVIDOR != 'localhost') ? 'Filipe Alves Vieira' : $v['email'];
                        $assunto = utf8_decode('PIBB - ' . ($aprova == 'A') ? 'Aprovação' : 'Recusa' . ' da compra nº ' . $retorno->getId());
                        $link = SITE . 'app/cadastros/aprovacao_pedidos/solicitacao.php?id=' . $retorno->getId();
                        $mensagemHTML = "<html>
                                            <div style='text-align:justify;width:80%'>
                                              <br>
                                              <p>Prezado!</p>
                                              <p>Em $data às $hora, foi pré-aprovada, a compra nº " . $retorno->getId() . ", pelo Sr(a). " . $nome_de . ".</p>
                                              <p>Para verificar, clique <a style='color:#39f' href='$link' target='_blank'>neste link</a>.</p>
                                              <p>    
                                              <p style='margin-bottom:0px;padding-bottom:0px;font-weight:bold'>Atenciosamente.</p>
                                            </div>
                                         </html>";
                        enviaEmail($assunto, $mensagemHTML, $email_de, $nome_de, $email_para, $nome_para, $msg_erro);
                    }
                }
            }
        }
    }

    $ret = [
        "erro" => false,
        "mensagem" => "Sucesso"
    ];
    echo json_encode($ret);
} catch (Exception $e) {
    $ret = [
        "erro" => true,
        "mensagem" => $e->getMessage()
    ];
    echo json_encode($ret);
}