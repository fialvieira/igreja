<?php

include "../../../def.php";
try{

  $u = unserialize($_SESSION['usuario']);

  if(!Aut::temPerfil(Aut::PERFIL_MASTER)){
    Aut::eMembro($u->getChurch());
  }
  Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO);

  $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
  $usuario = new \modelo\Usuario($codigo);

  $usuario->setChurch(EMPRESA);

  if(isset($_POST['nome']) && $_POST['nome']){
    $usuario->setNome($_POST['nome']);
  }
  if(isset($_POST['cpf']) && $_POST['cpf']){
    $usuario->setCpf(bd\Formatos::cpfBd($_POST['cpf']));
  }
  if(isset($_POST['email']) && $_POST['email']){
    $usuario->setEmail($_POST['email']);
  }
  if(isset($_POST['fone_movel']) && $_POST['fone_movel']){
    $usuario->setCelular(bd\Formatos::telefoneBd($_POST['fone_movel']));
  }
  if(isset($_POST['login']) && $_POST['login']){
    $usuario->setUsuario($_POST['login']);
  }

  if($_POST['cadastro_senha'] && $_POST['cadastro_senha2']){
    $usuario->setSenha($_POST['cadastro_senha']);
  }
  if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)){
    if(isset($_POST['perfil']) && $_POST['perfil']){
      $usuario->setPerfil($_POST['perfil']);
    }
  }
  $data = date('Y-m-d H:i:s');
  if(!is_null($codigo)){
    $usuario->setCodigo($codigo);
    $usuario->setModificacao($data);
  }else{
    $usuario->setCriacao($data);
    $usuario->setModificacao($data);
  }
  $usuario->salva();
  $usuario->setFullText();
  if(is_null($codigo)){
    $usuario->setUsersChurch();
  }
  $ret = ['erro' => false, 'id' => $usuario->getCodigo()];
}catch(\Exception $e){
  $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);
