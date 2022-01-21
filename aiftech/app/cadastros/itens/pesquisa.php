<?php
    use modelo\Item;
    include "../../../def.php";
    try {
        if (isset($_GET["texto"]) && $_GET["texto"] != "") {
            $texto = $_GET["texto"];
        } else {
            $texto = null;
        }
        $retorno = Item::seleciona($texto);

        include "pesquisa.html.php";
    } catch (\Exception $e) {
        \templates\Igreja::erro($e);
    }
?>