<?php
include "../../../def.php";
try {
   /* $u = unserialize($_SESSION['usuario']);

    if (!Aut::temPerfil(Aut::PERFIL_MASTER)) {
        Aut::eMembro($u->getChurch());
    }
    Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO);*/

    /*$perfis = \modelo\Usuario::PERFIS;*/
   /* $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
    $acao = $_GET['acao'];

    $membro = new \modelo\Membro($codigo);*/
    /*   * Ativar ou desativar usuário* */
    /*if ($acao == 'D') {
        $membro->desativarMembro();
        $msg = 'Membro desativado com sucesso.';
    } else {
        $membro->ativarMembro();
        $msg = 'Membro ativado com sucesso.';
    }
    $ret = ['erro' => false, 'mensagem' => $msg];*/
} catch (\Exception $e) {
    $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);