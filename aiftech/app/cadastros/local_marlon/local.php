
<?php    

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['LOCAIS'], \modelo\Permissao::WRITE);
    $codigo = (isset($_GET["codigo"]) && $_GET["codigo"] != "")? $_GET["codigo"] : null;
    $retorno = new \modelo\Local($codigo);
    $filtro = explode(",", $codigo);    
    include "local.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>