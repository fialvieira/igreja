<?php
    use modelo\Ata;
    include "../../../def.php";
    try {
        $ata = (isset($_GET["ata"]) && $_GET["ata"] != "")? $_GET["ata"] : null;
        $retorno = Ata::selecionaArquivos($ata,'N');
        if ($retorno) {
          include "arquivos.html.php";
        }
    } catch (\Exception $e) {
        \templates\Igreja::erro($e);
    }
?>