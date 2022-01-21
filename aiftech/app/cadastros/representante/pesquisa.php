<?php
    use modelo\Representante;
    include "../../../def.php";
    try {
        if (isset($_GET["texto"]) && $_GET["texto"] != "") {
            $texto = $_GET["texto"];
        } else {
            $texto = null;
        }
        $retorno = Representante::seleciona($texto);

        include "pesquisa.html.php";
    } catch (\Exception $e) {
        \templates\Igreja::erro($e);
    }
?>