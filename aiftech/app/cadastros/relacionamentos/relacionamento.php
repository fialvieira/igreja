
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\Relacionamento($id);
    $membros = \modelo\Membro::seleciona();
    $tiporelacionamentos = \modelo\Tiporelacionamento::seleciona();
    $membros = \modelo\Membro::seleciona();
    $filtro = explode(",", $id);    
    include "relacionamento.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>