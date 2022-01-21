<?php

use modelo\Orcamento;

include "../../../def.php";
try {
    Aut::filtraAutorizacao(Aut::$modulos['ACOMPANHAMENTO_ORCAMENTO']);
    $ano = ((isset($_GET["ano"]) && $_GET["ano"] != "") ? $_GET["ano"] : null);
    $mes = ((isset($_GET["mes"]) && $_GET["mes"] != "") ? $_GET["mes"] : null);

    $retorno = Orcamento::relatorio_acompanhamento($ano, $mes);
    if (!$retorno) {
        $msg = 'Não existe planejamento para o ';
        $msg .= (!is_null($mes)) ? 'mês de ' . mesPorExtenso($mes) . ' do ano de ' . $ano : 'ano de ' . $ano;
        throw new \Exception($msg);
    }
    $cat_ant = '';
    $orcamento = [];
    $arrMeses = [];

    $arrTotDespesas = [];
    foreach ($retorno as $value) {
        if ($cat_ant != $value['id']) {
            $cat_ant = $value['id'];
            $orcamento[$value['id']] = [
                'id' => $value['id'],
                'num' => $value['num'],
                'nome' => $value['nome'],
                'tipo' => $value['tipo'],
                'mae' => $value['mae'],
                'flag_mae' => $value['flag_mae'],
                'tot_previsto' => $value['valor_previsto'],
                'tot_realizado' => $value['valor_realizado'],
                'tot_porcentagem' => ($value['valor_previsto']) ? ($value['valor_realizado'] / $value['valor_previsto']) : 0,
                'tot_bonus' => ($value['valor_realizado'] - $value['valor_previsto']),
                'meses' => []
            ];
            array_push($orcamento[$value['id']]['meses'], [
                'ano' => $value['ano'],
                'mes' => $value['mes'],
                'descricao' => mesPorExtenso($value['mes']),
                'valor_previsto' => $value['valor_previsto'],
                'valor_realizado' => $value['valor_realizado'],
                'porcentagem' => ($value['valor_previsto']) ? ($value['valor_realizado'] / $value['valor_previsto']) : 0,
                'bonus' => ($value['valor_realizado'] - $value['valor_previsto']),
            ]);
        } else {
            $orcamento[$value['id']]['tot_previsto'] += $value['valor_previsto'];
            $orcamento[$value['id']]['tot_realizado'] += $value['valor_realizado'];
            if ($orcamento[$value['id']]['tot_previsto'] > 0) {
                $orcamento[$value['id']]['tot_porcentagem'] = $orcamento[$value['id']]['tot_realizado'] / $orcamento[$value['id']]['tot_previsto'];
            } else {
                $orcamento[$value['id']]['tot_porcentagem'] = 0;
            }
            $orcamento[$value['id']]['tot_bonus'] = $orcamento[$value['id']]['tot_realizado'] - $orcamento[$value['id']]['tot_previsto'];

            array_push($orcamento[$value['id']]['meses'], [
                'ano' => $value['ano'],
                'mes' => $value['mes'],
                'descricao' => mesPorExtenso($value['mes']),
                'valor_previsto' => $value['valor_previsto'],
                'valor_realizado' => $value['valor_realizado'],
                'porcentagem' => ($value['valor_previsto']) ? ($value['valor_realizado'] / $value['valor_previsto']) : 0,
                'bonus' => ($value['valor_realizado'] - $value['valor_previsto']),
            ]);
        }
        if (array_search($value['mes'], $arrMeses) === false) {
            $arrMeses [$value['mes']] = [
                'mes' => $value['mes'],
                'descricao' => mesPorExtenso($value['mes']),
                'ano' => $value['ano']
            ];
        }
        if ($value['tipo'] == 'Despesas' && is_null($value['mae'])) {
            if (count($arrTotDespesas) == 0) {
                $arrTotDespesas = [
                    'tot_previsto' => $value['valor_previsto'],
                    'tot_realizado' => $value['valor_realizado'],
                    'tot_porcentagem' => ($value['valor_previsto'] > 0) ? ($value['valor_realizado'] / $value['valor_previsto']) : 0,
                    'tot_bonus' => ($value['valor_realizado'] - $value['valor_previsto']),
                    'meses' => []
                ];
            } else {
                $arrTotDespesas['tot_previsto'] += $value['valor_previsto'];
                $arrTotDespesas['tot_realizado'] += $value['valor_realizado'];
                $arrTotDespesas['tot_porcentagem'] = ($arrTotDespesas['tot_previsto'] > 0) ? ($arrTotDespesas['tot_realizado'] / $arrTotDespesas['tot_previsto']) : 0;
                $arrTotDespesas['tot_bonus'] = ($arrTotDespesas['tot_realizado'] - $arrTotDespesas['tot_previsto']);
            }
            if (!array_key_exists($value['mes'], $arrTotDespesas['meses'])) {
                $arrTotDespesas['meses'][$value['mes']] = [
                    'ano' => $value['ano'],
                    'mes' => $value['mes'],
                    'valor_previsto' => $value['valor_previsto'],
                    'valor_realizado' => $value['valor_realizado'],
                    'porcentagem' => ($value['valor_previsto']) ? ($value['valor_realizado'] / $value['valor_previsto']) : 0,
                    'bonus' => ($value['valor_realizado'] - $value['valor_previsto']),
                ];
            } else {
                $arrTotDespesas['meses'][$value['mes']]['valor_previsto'] += $value['valor_previsto'];
                $arrTotDespesas['meses'][$value['mes']]['valor_realizado'] += $value['valor_realizado'];
                $arrTotDespesas['meses'][$value['mes']]['porcentagem'] = ($arrTotDespesas['meses'][$value['mes']]['valor_previsto'] > 0) ?
                        ($arrTotDespesas['meses'][$value['mes']]['valor_realizado'] / $arrTotDespesas['meses'][$value['mes']]['valor_previsto']) : 0;
                $arrTotDespesas['meses'][$value['mes']]['bonus'] = ($arrTotDespesas['meses'][$value['mes']]['valor_realizado'] - $arrTotDespesas['meses'][$value['mes']]['valor_previsto']);
            }
        }
    }
    if (count($arrMeses) > 0) {
        ksort($arrMeses);
    }
    if (count($arrTotDespesas) > 0) {
        ksort($arrTotDespesas['meses']);
    }

    $_SESSION['orcamento'] = $orcamento;
    $_SESSION['orc_arrMeses'] = $arrMeses;
    $_SESSION['orc_arrTotDespesas'] = $arrTotDespesas;

    $data = date("d-m-Y");
    $file_name = 'Acompanhamento_orçamento_' . $ano . '(' . $data . ')';
    echo json_encode(['erro' => false, 'msg' => $file_name]);
} catch (\Exception $e) {
    echo json_encode(['erro' => true, 'msg' => $e->getMessage()]);
}
