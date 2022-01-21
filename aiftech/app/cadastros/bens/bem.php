
<?php    

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['BENS'], \modelo\Permissao::WRITE);
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\Bem($id);
    $filtro = explode(",", $id);  
    $manual = '';//RAIZ."docs/manuais/Cadastro_Bem.pdf";    
    
    $departamentos = \modelo\Departamento::seleciona('S');
    $locais = \modelo\Local::seleciona();
    $tipo_bens = \modelo\TipoBem::seleciona('S');
    
    include "bem.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>