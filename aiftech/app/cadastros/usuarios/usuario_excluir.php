<?php
include "../../../def.php";
try{

  $u = unserialize($_SESSION['usuario']);

  if(!Aut::temPerfil(Aut::PERFIL_MASTER)){
    Aut::eMembro($u->getChurch());
  }
  Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO);

  $perfis = \modelo\Usuario::PERFIS;
  $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
  $acao = $_GET['acao'];
  $usuario = new \modelo\Usuario($codigo);
  /*   * Ativar ou desativar usuário* */
  if($acao == 'D'){
    $usuario->excluirUsuario('u');
    $msg = 'Usuário desativado com sucesso.';
  }else{
    $usuario->ativarUsuario();
    $msg = 'Usuário ativado com sucesso.';
  }
  $ret = ['erro' => false, 'mensagem' => $msg];
}catch(\Exception $e){
  $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);