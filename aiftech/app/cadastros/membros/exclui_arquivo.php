<?php

use modelo\Membro;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE);
    $id = (isset($_POST["id"]) && $_POST["id"] != "") ? $_POST["id"] : null;
    $m = new Membro($id);
    $path = $m->getImagem();
    if ($path != 'arquivos/no-image.png') {
        $path = RAIZ . $path;
        if (unlink($path)) {
            $m->setImagem(null);
            $m->gravaImagem();
        }
        $ret = ["erro" => false, "mensagem" => "Imagem excluída com sucesso"];
    } else {
        $ret = ["erro" => false, "mensagem" => "Não existe imagem para ser excluída"];
    }
    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}