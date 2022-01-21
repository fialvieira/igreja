
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\Endereco($id);
    $estados = \modelo\Estado::seleciona();
    $membros = \modelo\Membro::seleciona();
    $filtro = explode(",", $id);    
    include "endereco.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>