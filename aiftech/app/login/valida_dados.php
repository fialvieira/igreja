<?php

include "../../def.php";

try {
    $login = $_GET['reset_login'];
    $cpf = $_GET['reset_cpf'];
    $email = $_GET['reset_email'];
    if ($login === '' || $cpf === '') {
        throw new Exception('Necessário preencher login e CPF');
    }

    $user = modelo\Usuario::existeLogin($login, $cpf, $email);
    if (!$user['id']) {
        throw new \Exception('Login não encontrado, verifique os dados informados.');
    }
    $usuario = new modelo\Usuario($user['id']);
    $senha = random_int(100000, 99999999);
    $usuario->setSenha($senha);
    $usuario->salva();
    $link = SITE . 'app/login/index.php#novasenha=' . $senha;

    $empresa = new \modelo\Empresa(EMPRESA);

    include './envia_email.php';
    $ret = ['erro' => false, 'mensagem' => 'E-mail com instruções para redefinição de senha enviado com sucesso.'];
} catch (\Exception $e) {
    $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);
