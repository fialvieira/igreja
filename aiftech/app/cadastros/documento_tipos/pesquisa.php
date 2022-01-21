<?php
    use modelo\DocumentoTipo;
    include "../../../def.php";
    try {
        Aut::filtraAutorizacao(Aut::$modulos['TIPOS_DOCUMENTO']);
        if (Aut::temPermissao(Aut::$modulos['TIPOS_DOCUMENTO'], \modelo\Permissao::REWRITE)) {      
            $retorno = DocumentoTipo::seleciona('T');
            $permitido = true;
        } else {
            $retorno = DocumentoTipo::seleciona();
            $permitido = false;
        }
        include "pesquisa.html.php";
    } catch (\Exception $e) {
        \templates\Igreja::erro($e);
    }
?>