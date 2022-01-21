
<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['TIPOS_ATA'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\AtaTipo($id);
    $filtro = explode(",", $id);
    $manual = RAIZ . "docs/manuais/Cadastro_Tipos_Ata.pdf";
    $arrCartorio = [
        'S' => 'Sim',
        'N' => 'Não'
    ];

    include "./ata_tipo.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>