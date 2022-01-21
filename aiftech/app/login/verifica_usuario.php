<?php 
include "../../def.php";
//Aut::filtraLogado();

try {
  $cpf = ($_GET['cpf'] == '') ? null : $_GET['cpf'];
  $senha = ($_GET['senha'] == '') ? null : $_GET['senha'];
  $cpf = bd\Formatos::cpfBd($cpf);
  //Verifica se já existe usuário cadastrado
  $ret = modelo\Usuario::getIdUsuarioPorCPF($cpf);
  if (!$ret['USUARIO']) {
//        $usuario = new modelo\Usuario($ret['id']);
    throw new Exception('Não existe usuário com este CPF.');
  } else {
    if (!password_verify($senha, $ret['senha'])) {
      throw new Exception('Operação inválida.');
    }
    $retorno = [
        'ERRO' => false
    ];
//        }
    echo json_encode($retorno);
  }
} catch (\Exception $e) {
  $retorno = [
      'ERRO' => true,
      'MSG' => $e->getMessage()
  ];
  echo json_encode($retorno);
}