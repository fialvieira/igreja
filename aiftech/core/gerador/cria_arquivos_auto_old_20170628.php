<?php

use gerador\TabelasAuto;

include "../../def.php";

try {
    $tabelas = gerador\TabelasAuto::listaTabelas();
    foreach ($tabelas as $tabela) {
        $tbl = new TabelasAuto($tabela['tabela']);
        $titulo = $tabela['descricao'];

        $campos = $tbl->getTabela();
        $tabs_relaciona = "";
        $tabs_combo = "";
        foreach ($campos as $campo) {
            if ($campo["RELACIONA_TABELA"] != "") {
//                $tabs_relaciona = $campo["RELACIONA_TABELA"] . ":" . $campo["CAMPO"] . ";" . $campo["RELACIONA_VALOR"] . ";" . $campo["RELACIONA_DESCRICAO"] . '?';
                $tabs_relaciona [] = ['TAB_REL' => $campo['RELACIONA_TABELA'].':'.$campo['CAMPO'].';'.$campo['RELACIONA_VALOR'].';'.$campo['RELACIONA_DESCRICAO']];
            }
            if ($campo["COMBO"] != "") {
                foreach ($campo["COMBO"] as $value) {
                    if ($value["DESC_IS_VALUE"]) {
                      $descricao = $value["VALOR"];  
                    } else {
                      $descricao = $value["DESCRICAO"];  
                    }
                    $tabs_combo ["TAB_CMB"][$campo["CAMPO"]][] = $value["VALOR"] . ";" . $descricao;
                }
            }
        }
        if ($tabs_relaciona){
            $tabs_relaciona = json_encode($tabs_relaciona);
        }
        if($tabs_combo){
            $tabs_combo = json_encode($tabs_combo);
        }
        
        $template = Sistema::$template;
        include "cria_arquivo_index.php";
        include "cria_arquivo_consulta.php";
        include "cria_arquivo_cadastro.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}


