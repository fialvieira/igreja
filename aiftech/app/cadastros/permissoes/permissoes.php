
<?php    

include "../../../def.php";
use modelo\Permissao;

try {
    $usuario_id = (isset($_GET["user"]) && $_GET["user"] != "")? $_GET["user"] : null;
    $usuarios = modelo\Usuario::seleciona(EMPRESA, null, 'S');
//    $menus = Permissao::selecionaMenus();
//    $modulos = Permissao::selecionaModulos();
    $permissoes = Permissao::PERMISSOES;
    $retorno = Permissao::selecionaPorUsuario($usuario_id);
    $menu_ant = null;
    include "permissoes.html.php";    
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>