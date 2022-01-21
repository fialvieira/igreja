<?php

use modelo\Departamento;

include "../../../def.php";
try {
   /* Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::ADMINISTRATIVO, Aut::PRESIDENTE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Departamento($id);
    $exclui = $retorno->exclui();
    $ret = ['erro' => ($exclui) ? false : true,
            'mensagem' => ($exclui) ? 'Sucesso ao excluir' : 'Erro ao excluir'
        ];*/
    echo json_encode($ret);
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}