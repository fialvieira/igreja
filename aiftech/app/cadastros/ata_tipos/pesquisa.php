<?php
    use modelo\AtaTipo;
    include "../../../def.php";
    try {
        Aut::filtraAutorizacao(Aut::$modulos['TIPOS_ATA']);
        if (Aut::temPermissao(Aut::$modulos['TIPOS_ATA'], \modelo\Permissao::REWRITE)) {      
            $retorno = AtaTipo::seleciona('T');
            $permitido = true;
        } else {
            $retorno = AtaTipo::seleciona();
            $permitido = false;
        }
        $arrCartorio = [
            '' => '',
            'S' => 'Sim',
            'N' => 'Não'
        ];
        include "pesquisa.html.php";
    } catch (\Exception $e) {
        \templates\Igreja::erro($e);
    }
?>