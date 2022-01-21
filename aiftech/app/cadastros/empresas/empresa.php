
<?php

include "../../../def.php";

try {
    Aut::filtraPermissao(Aut::$modulos['IGREJAS'], \modelo\Permissao::WRITE);
    if (Aut::temPermissao(Aut::$modulos['IGREJAS'], \modelo\Permissao::WRITE)) {
        $permitido = true;
    } else {
        $permitido = false;
    }

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Empresa($id);
    $pastores = \modelo\Pastor::listaPastores();
    $estados = \modelo\Estado::seleciona();
    $associacoes = \modelo\Associacao::seleciona('S');

    if ($retorno->getEndereco() != '') {
        $end = new \modelo\Endereco($retorno->getEndereco());
        $end_flag = true;
    } else {
        $end_flag = false;
    }
    if ($retorno->getId() !== EMPRESA && $retorno->getCliente() == 'S') {
        $permitido = false;
    }
    
    $manual = RAIZ . "docs/manuais/Cadastro_Igrejas.pdf";
    include "empresa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>