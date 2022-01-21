<?php

use modelo\Permissao;

include "../../../def.php";
try {
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $user = (isset($_GET["user"]) && $_GET["user"] != "") ? $_GET["user"] : null;

    $permissoes = json_decode($_GET['permissoes'], true);
    foreach ($permissoes as $permissao) {
        $retorno = new Permissao($permissao['id']);
        if ($permissao['permissao']) {
            $retorno->setUsuarioId($user);
            $retorno->setModuloId($permissao['modulo_id']);
            $retorno->setPermissao($permissao['permissao']);
            $retorno->setEmpresaId(EMPRESA);
            $retorno->setUserId($usuario->getCodigo());
            $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
            $retorno->setModified($dh_atual);
            $retorno->salva();
        } else {
            if ($retorno->getid()) {
                $retorno->setUserId($usuario->getCodigo());
                $retorno->exclui();
            }
        }
    }

    $ret = ["erro" => false];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
