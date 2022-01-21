<?php

use bd\Formatos;

include "../../def.php";
//Aut::filtraLogado();

try {

  if (isset($_POST['cpf_senha']) && $_POST['cpf_senha']) {
    $cpf = Formatos::cpfBd($_POST['cpf_senha']);
  }
  if ($_POST['nova_senha']) {
    $senha = $_POST['nova_senha'];
  }
  $user = modelo\Usuario::getIdUsuarioPorCPF($cpf);
  
  $usuario = new \modelo\Usuario($user['id']);

  $usuario->setSenha($senha);

  $usuario->salva();

  $ret = ['erro' => false, 'id' => $usuario->getCodigo()];
} catch (\Exception $e) {
  $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);
