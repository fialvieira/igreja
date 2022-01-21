
<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['TIPOS_DOCUMENTO'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\DocumentoTipo($id);
    $manual = RAIZ . "docs/manuais/Cadastro_Tipos_Documento.pdf";
    $arrArq = explode('/', $retorno->getPathModelo());
    $nome_arq = $arrArq[count($arrArq)-1];
    include "./documento_tipo.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>