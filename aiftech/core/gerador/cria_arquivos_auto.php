<?php

use gerador\Gerador;

include "../../def.php";

$tabelas = json_decode($_POST['itens'], TRUE);
foreach ($tabelas as $tabela) {
    try {
        $campos = Gerador::construtor(strtolower($tabela['tabela']));
        $nome_tabela = $tabela['tabela'];
        if (substr($nome_tabela, -3, 3) == 'oes') {
            $nome_tabela = substr($nome_tabela, 0, -3) . 'ao';
        } else if (substr($nome_tabela, -3, 3) == 'res') {
            $nome_tabela = substr($nome_tabela, 0, -2);
        }
        switch (substr($nome_tabela, -2, 2)) {
            case 'is':
                $nome_tabela = substr($nome_tabela, 0, -2) . 'l';
                break;
            case 'ns':
                $nome_tabela = substr($nome_tabela, 0, -2) . 'm';
                break;
            case
                $nome_tabela = (substr($nome_tabela, -1, 1) == 's')? substr($nome_tabela, 0, -1) : $nome_tabela;
                break;
        }
        
        $titulo = $tabela['descricao'];
        $modelo = str_replace(" ", "", ucwords(str_replace("_", " ", $nome_tabela)));
        $tabs_relaciona = "";
        $tabs_combo = "";
        $relaciona_modelo = "";
        if (!$campos) {
            throw new \Exception('Erro ao gerar cadastro para table ' . $tabela['tabela'] . ', verifique! <br>');
        }
        foreach ($campos as $campo) {
            if ($campo["RELACIONA_TABELA"] != "") {
                $tabs_relaciona [] = ['TAB_REL' => $campo['RELACIONA_TABELA'] . ':' . $campo['CAMPO'] . ';' . $campo['RELACIONA_VALOR'] . ';' . $campo['RELACIONA_DESCRICAO']];

                $nome_tabela_relaciona = $campo['RELACIONA_TABELA'];
                if (substr($nome_tabela, -3, 3) == 'oes') {
                    $nome_tabela_relaciona = substr($nome_tabela_relaciona, 0, -3) . 'ao';
                } else if (substr($nome_tabela_relaciona, -3, 3) == 'res') {
                    $nome_tabela_relaciona = substr($nome_tabela_relaciona, 0, -2);
                }
                switch (substr($nome_tabela_relaciona, -2, 2)) {
                    case 'is':
                        $nome_tabela_relaciona = substr($nome_tabela_relaciona, 0, -2) . 'l';
                        break;
                    case 'ns':
                        $nome_tabela_relaciona = substr($nome_tabela_relaciona, 0, -2) . 'm';
                        break;
                    case
                        $nome_tabela_relaciona = (substr($nome_tabela_relaciona, -1, 1) == 's')? substr($nome_tabela_relaciona, 0, -1) : $nome_tabela_relaciona;
                        break;
                }
                $relaciona_modelo [] = [
                    'nome' => $campo['RELACIONA_TABELA'],
                    'modelo' => str_replace(" ", "", ucwords(str_replace("_", " ", $nome_tabela_relaciona))),
                    'id' => $campo['RELACIONA_VALOR'],
                    'descricao' => $campo['RELACIONA_DESCRICAO'],
                    'valor' => str_replace(" ", "", ucwords(str_replace("_", " ", $campo['CAMPO'])))
                ];
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
        if ($tabs_relaciona) {
            $tabs_relaciona = json_encode($tabs_relaciona);
        }
        if ($tabs_combo) {
            $tabs_combo = json_encode($tabs_combo);
        }
        $foreign_key =Gerador::listaKeys($tabela['tabela']);
        
        $template = Sistema::$template;

        include "cria_arquivo_sql.php";
        include "cria_arquivo_modelo.php";
        include "cria_arquivo_index.php";
        include "cria_arquivo_pesquisa.php";
        include "cria_arquivo_cadastro.php";

        $ret = ['erro' => false];
    } catch (\Exception $e) {
        $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
    }
}
echo json_encode($ret);


