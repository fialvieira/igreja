<?php

use modelo\Documento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['DOCUMENTOS'], modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;

    $retorno = new Documento($id);

    if (isset($_GET["data"]) && $_GET["data"] != "") {
        $retorno->setData($_GET["data"]);
    }
    if (isset($_GET["hora"]) && $_GET["hora"] != "") {
        $retorno->setHora($_GET["hora"]);
    }
    if (isset($_GET["tipo"]) && $_GET["tipo"] != "") {
        $retorno->setTipoDocumento($_GET["tipo"]);
    }
    $tipo_desc = '';
    if (isset($_GET["tipo_desc"]) && $_GET["tipo_desc"] != "") {
        $tipo_desc = $_GET["tipo_desc"];
    }
    if (isset($_GET["presidencia"]) && $_GET["presidencia"] != "") {
        $retorno->setPresidencia($_GET["presidencia"]);
    }
    $nome_membros = '';
    if (isset($_GET["nome_membros"]) && $_GET["nome_membros"] != "") {
        $nome_membros = $_GET["nome_membros"];
    }
    if (isset($_GET["secretario"]) && $_GET["secretario"] != "") {
        $retorno->setSecretario($_GET["secretario"]);
    }
    if (isset($_GET["ata"]) && $_GET["ata"] != "") {
        $retorno->setAtaId($_GET["ata"]);
    }
    $ata_num = '';
    if (isset($_GET["ata_num"]) && $_GET["ata_num"] != "") {
        $ata_num = $_GET["ata_num"];
    }
    if (isset($_GET["igreja_destino_id"]) && $_GET["igreja_destino_id"] != "") {
        $retorno->setIgrejaDestinoId($_GET["igreja_destino_id"]);
    }
    $igreja = '';
    if (isset($_GET["igreja_destino"]) && $_GET["igreja_destino"] != "") {
        $igreja = $_GET["igreja_destino"];
    }
    if (isset($_GET["pastor_destino_id"]) && $_GET["pastor_destino_id"] != "") {
        $retorno->setPastorDestinoId($_GET["pastor_destino_id"]);
    }
    $pastor = '';
    if (isset($_GET["pastor_destino"]) && $_GET["pastor_destino"] != "") {
        $pastor = $_GET["pastor_destino"];
    }
    if (isset($_GET["data_carta"]) && $_GET["data_carta"] != "") {
        $retorno->setDataCarta($_GET["data_carta"]);
    }
    if (isset($_GET["extensao"]) && $_GET["extensao"] != "") {
        $retorno->setExtensao($_GET["extensao"]);
    }
    if (isset($_GET["path_arquivo"]) && $_GET["path_arquivo"] != "") {
        $retorno->setPathArquivo($_GET["path_arquivo"]);
    } else {
        $retorno->setPathArquivo(NULL);
    }

    if (!isset($_GET["finaliza"]) || $_GET["finaliza"] == '') {
        if (isset($_GET["membros"]) && $_GET["membros"] != "") {
            $retorno->setMembros($_GET["membros"]);
        } else {
            $retorno->setMembros(NULL);
        }

        $documento_ft = $retorno->getId() . ' ' . $retorno->getNum() . ' ' . $retorno->getData() . ' DIA:' . substr($retorno->getData(), 0, 2)
                . ' MES:' . substr($retorno->getData(), 3, 2) . ' ANO:' . substr($retorno->getData(), 6, 4) . ' '
                . $retorno->getTipoDocumento() . ' ' . $tipo_desc . ' ' . $retorno->getPresidenciaNome() . ' ' . $nome_membros 
                . ' ' . $ata_num . ' ' . $retorno->getDataCarta() . ' ' . $igreja . ' ' . $pastor . ' ' . $retorno->getSecretarioNome();
        $retorno->setDocumentoFt($documento_ft);
    } else {
        $retorno->setFinalizado($_GET["finaliza"]);
    }
    
    $retorno->setUserId($usuario->getCodigo());
    $retorno->setEmpresaId(EMPRESA);
    $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
    $retorno->setModified($dh_atual);

    $retorno->salva();

    $ret = [
        "erro" => false,
        "doc" => $retorno->getId(),
        "num" => $retorno->getNum()
    ];
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
}
echo json_encode($ret);
?>