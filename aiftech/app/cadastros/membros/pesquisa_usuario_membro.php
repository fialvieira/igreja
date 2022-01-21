<?php

use modelo\Membro;
use modelo\Usuario;
use bd\Formatos;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['MEMBROS']);
    $cpf = ($_GET['cpf'] == '') ? null : $_GET['cpf'];
    $cpf = Formatos::cpfBd($cpf);
    //Verifica se já existe membro cadastrado
    $ret_membro = Membro::getIdMembroPorCPF($cpf);
    if ($ret_membro['MEMBRO']) {
        $membro = new Membro($ret_membro['id']);
        throw new Exception('Membro ' . $membro->getNome() . ' já cadastrado');
    } else {
        //Verifica se já existe usuário cadastrado
        $ret = Usuario::getIdUsuarioPorCPF($cpf);
        if ($ret['USUARIO']) {
            $usuario = new Usuario($ret['id']);
            $retorno = [
                'ERRO' => false,
                'USERS' => true,
                'MSG' => 'Importando dados de users',
                'NOME' => $usuario->getNome(),
                'CELULAR' => $usuario->getCelular(),
                'EMAIL' => $usuario->getEmail()
            ];
        } else {
            $retorno = [
                'ERRO' => false,
                'USERS' => false,
                'MSG' => 'Não há registro em users'
            ];
        }
        echo json_encode($retorno);
    }
} catch (\Exception $e) {
    $retorno = [
        'ERRO' => true,
        'MSG' => $e->getMessage()
    ];
    echo json_encode($retorno);
}