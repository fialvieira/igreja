
<?php    

include "../../../def.php";

try {
//    Aut::filtraPermissao(Aut::$modulos['TIPO_BENS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\TipoBem($id);
    $filtro = explode(",", $id);  
    $manual = '';//RAIZ."docs/manuais/Cadastro_de_Tipo de Bem.pdf";    
    include "tipo_bem.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>