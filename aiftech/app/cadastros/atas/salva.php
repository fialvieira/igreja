<?php

use modelo\Ata;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['ATAS'], modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_POST["id"]) && $_POST["id"] != "") ? $_POST["id"] : null;
    $retorno = new Ata($id);

    if (isset($_POST["data"]) && $_POST["data"] != "") {
        $retorno->setData($_POST["data"]);
    }
    if (isset($_POST["tipo"]) && $_POST["tipo"] != "") {
        $retorno->setTipoAta($_POST["tipo"]);
    }
    if (isset($_POST["presidencia"]) && $_POST["presidencia"] != "") {
        $retorno->setPresidencia($_POST["presidencia"]);
    }
    if (isset($_POST["tx_corpo"]) && $_POST["tx_corpo"] != "") {
        $retorno->setTxCorpo($_POST["tx_corpo"]);
    }
    if (isset($_POST["secretario"]) && $_POST["secretario"] != "") {
        $retorno->setSecretario($_POST["secretario"]);
    }

    $arquivos = null;
    if (isset($_POST['arquivos'])) {
        $arquivos = json_decode($_POST['arquivos'], TRUE);
    }
    $arquivos_ft = '';
    if ($arquivos) {
        foreach ($arquivos as $arquivo) {
            $arquivos_ft .= $arquivo['nome'] . ' ';
        }
    }

    if (!isset($_POST["finaliza"]) || $_POST["finaliza"] == '') {
        $ata_ft = $retorno->getNum() . ' ' . $retorno->getData() . ' DIA:' . substr($retorno->getData(), 0, 2) . ' MES:' . substr($retorno->getData(), 3, 2) .
                ' ANO:' . substr($retorno->getData(), 6, 4) . ' ' . $retorno->getTipoAta() . ' ' . $retorno->getPresidenciaNome() . /* ' ' . $retorno->getTxAbertura() . */
                ' ' . $retorno->getTxCorpo() . /* ' ' . $retorno->getTxEncerramento() . */ ' ' . $retorno->getSecretarioNome() . ' ' . /* $assuntos_ft . */ $arquivos_ft; //$participantes_ft;
        $retorno->setAtaFt($ata_ft);
    } else {
        $retorno->setFinalizado($_POST["finaliza"]);
    }

    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);

    $retorno->salva();

    if ($arquivos) {
        foreach ($arquivos as $arquivo) {
            $retorno->salvaArquivo($arquivo['path'], $arquivo['nome'], $arquivo['ata_digit']);
        }
    }
    $ret = [
        "erro" => false,
        "ata" => $retorno->getId(),
        "num" => $retorno->getNum(),
        "finalizado" => $retorno->getFinalizado()
    ];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
?>