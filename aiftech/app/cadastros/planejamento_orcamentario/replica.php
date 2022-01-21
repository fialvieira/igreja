<?php

use modelo\Orcamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::WRITE);
    $usuario = unserialize($_SESSION["usuario"]);
    $dh_atual = date("Y-m-d H:i:s");
    $meses = mesPorExtenso();

    $ano_de = (isset($_GET["ano_de"]) && $_GET["ano_de"] != "") ? $_GET["ano_de"] : null;
    $ano_para = (isset($_GET["ano_para"]) && $_GET["ano_para"] != "") ? $_GET["ano_para"] : null;
    $mes_de = (isset($_GET["mes_de"]) && $_GET["mes_de"] != "") ? $_GET["mes_de"] : null;
    $mes_para = (isset($_GET["mes_para"]) && $_GET["mes_para"] != "") ? $_GET["mes_para"] : null;

//--> Verificar possíveis combinações de parametros permitidos para duplicação
    if ($ano_para < $ano_de) {
        throw new \Exception('Obrigatório o campo "De Ano" ser menor que o campo "Para Ano".');
    } else if ($ano_para == $ano_de) {
        if (is_null($mes_de) && is_null($mes_para)) {
            throw new \Exception('Obrigatório o campo "De Ano" ser menor que o campo "Para Ano".');
        }
        if (!is_null($mes_para) && $mes_para < $mes_de) {
            throw new \Exception('Obrigatório o campo "De Mês" ser menor que o campo "Para Mês".');
        }
    }
    if (!is_null($mes_para) && is_null($mes_de)) {
        throw new \Exception('Obrigatório preencher o campo "De Mês" quando o campo "Para Mês" esta preenchido.');
    }
//<--
//--> Verifica se existe algum lançamento de planejamento para o Ano / Mes destino (Para), se tiver ele irá remover os meses já lançados.
    $result = Orcamento::seleciona($ano_para, $mes_para);
    if ($result) {
        foreach ($result as $res) {
            unset($meses[intval($res['mes'])]);
        }
    }
//<--
//--> Verifica se não tiver mes sem lançamento para o Ano / Mes destino emite msg de erro.
    if (count($meses) == 0) {
        $msg = 'Já existe orçamentos lançados para o ano ' . $ano_para;
        $msg .= (!is_null($mes_para)) ? ' e mês ' . $mes_para . ', não é possível realizar a replicação' : ', não é possível realizar a replicação';
        throw new \Exception($msg);
    }
//<--
//--> Faz os lançamentos do Ano / Mes(es) sem lançamentos.    
    $orcamentos = Orcamento::seleciona($ano_de, $mes_de);
    if (!$orcamentos) {
        $msg = 'Não existe orçamentos lançados para o ano ' . $ano_de;
        $msg .= (!is_null($mes_de)) ? ' e mês ' . $mes_de : '';
        throw new \Exception($msg);
    }
    if (!is_null($mes_de) && is_null($mes_para)) {
        foreach ($meses as $k => $v) {
            foreach ($orcamentos as $orcamento) {
                $retorno = new Orcamento();
                $retorno->setAno($ano_para);
                $retorno->setMes(str_pad($k, 2, '0', STR_PAD_LEFT));
                $retorno->setCategoriaId($orcamento['categoria_id']);
                $retorno->setValorPrevisto($orcamento['valor_previsto']);
                $retorno->setEmpresaId(EMPRESA);
                $retorno->setUserId($usuario->getCodigo());
                $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
                $retorno->setModified($dh_atual);
                $retorno->salva();
            }
        }
    } else {
//--> Verifica se o Mes origem (De) esta vazio e se existe algum lançamento de planejamento para o Ano / Mes destino (Para), se tiver ele irá remover orçamentos já lançados.
        if (is_null($mes_de)) {
            if ($result) {
                foreach ($result as $res) {
                    foreach (array_keys(array_column($orcamentos, 'mes'), $res['mes']) as $key) {
                        unset($orcamentos[$key]);
                    }
                }
            }
        }
//<--        
        foreach ($orcamentos as $orcamento) {
            $retorno = new Orcamento();
            $retorno->setAno($ano_para);

            if (is_null($mes_de) && is_null($mes_para)) {
                $retorno->setMes($orcamento['mes']);
            } elseif (!is_null($mes_de) && !is_null($mes_para)) {
                $retorno->setMes($mes_para);
            }

            $retorno->setCategoriaId($orcamento['categoria_id']);
            $retorno->setValorPrevisto($orcamento['valor_previsto']);
            $retorno->setEmpresaId(EMPRESA);
            $retorno->setUserId($usuario->getCodigo());
            $retorno->setCreated(($retorno->getCreated()) ? $retorno->getCreated() : $dh_atual);
            $retorno->setModified($dh_atual);
            $retorno->salva();
        }
    }
//<--

    $ret = ["erro" => false];
} catch (\Exception $e) {
    $msg = $e->getMessage();
    if (strpos($msg, 'Duplicate') !== false) {
        $msg = 'Planejamento para o ano, mês e conta informados já existe.';
    }
    $ret = ["erro" => true, "mensagem" => $msg];
}
echo json_encode($ret);
