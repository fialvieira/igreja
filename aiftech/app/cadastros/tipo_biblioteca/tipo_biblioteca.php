
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\TipoBiblioteca($id);
    $filtro = explode(",", $id);    
    include "tipo_biblioteca.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>