<?php
use bd\Formatos;
include "../../def.php";
dd(EMPRESA);
try {
  $usuario = new \modelo\Usuario();
  $usuario->setChurch(EMPRESA);
  if (isset($_POST['nome']) && $_POST['nome']) {
    $usuario->setNome($_POST['nome']);
  }
  if (isset($_POST['cpf']) && $_POST['cpf']) {
    $usuario->setCpf(Formatos::cpfBd($_POST['cpf']));
  }
  if (isset($_POST['email']) && $_POST['email']) {
    $usuario->setEmail($_POST['email']);
  }
  if (isset($_POST['fone_movel']) && $_POST['fone_movel']) {
    $usuario->setCelular(Formatos::telefoneBd($_POST['fone_movel']));
  }
  if (isset($_POST['login']) && $_POST['login']) {
    $usuario->setUsuario($_POST['login']);
  }
  if ($_POST['cadastro_senha']) {
    $usuario->setSenha($_POST['cadastro_senha']);
  }
  if (isset($_POST['perfil']) && $_POST['perfil']) {
    $usuario->setPerfil($_POST['perfil']);
  }else{
      $usuario->setPerfil(6);
  }
  $data = date('Y-m-d H:i:s');
  $usuario->setCriacao($data);
  $usuario->setModificacao($data);
  $usuario->salva();
  $usuario->setFullText();
  $usuario->setUsersChurch();
  $ret = ['erro' => false, 'id' => $usuario->getCodigo()];
} catch (\Exception $e) {
  $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);