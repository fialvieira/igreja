
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
    $retorno = new \modelo\Item($id);
    $autores = \modelo\Autor::seleciona();
    $categorias = \modelo\Categoria::seleciona();
    $editoras = \modelo\Editora::seleciona();
    $tipo_biblioteca = \modelo\TipoBiblioteca::seleciona();
    $filtro = explode(",", $id);    
    include "item.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>