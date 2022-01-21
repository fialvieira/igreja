
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\MovimentacaoItem($id);
    $membros = \modelo\Membro::seleciona();
    $itens = \modelo\Item::seleciona();
    $filtro = explode(",", $id);    
    include "movimentacao_item.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>