<?php
include "../../def.php";
try {
    $cpf = ($_GET['cpf'] == '') ? null : $_GET['cpf'];
    $cpf = bd\Formatos::cpfBd($cpf);
    //Verifica se já existe usuário cadastrado
    $ret = modelo\Usuario::getIdUsuarioPorCPF($cpf);
    if ($ret['USUARIO']) {
        $usuario = new modelo\Usuario($ret['id']);
        throw new Exception('Usuário ' . $usuario->getNome() . ' já cadastrado');
    } else {
        //Verifica se já existe registro em membros
        $ret_membro = \modelo\Membro::getIdMembroPorCPF($cpf);
        if ($ret_membro['MEMBRO']) {
            $membro = new modelo\Membro($ret_membro['id']);
            $retorno = [
                'ERRO' => false,
                'MEMBROS' => true,
                'MSG' => 'Importando dados de membros',
                'NOME' => $membro->getNome(),
                'CELULAR' => $membro->getCel(),
                'EMAIL' => $membro->getEmail()
            ];
        } else {
            $retorno = [
                'ERRO' => false,
                'MEMBROS' => false,
                'MSG' => 'Não há registro em membros'
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