<?php

namespace modelo;

use bd\My;

class RelatoriosCaixa
{
    private $empresa_id;
    private $ano;
    private $mes;
    private $tipo;
    private $cancelado;

    public function __construct($ano, $mes)
    {
        $this->empresa_id = EMPRESA;
        $this->ano = $ano;
        $this->mes = $mes;
    }

    /*
     * Primeira função recursiva, pode ser excluída no futuro
     * */
    public function categoriasFinanceirasRecursivo(&$output = null, $parent = 1)
    {
        try {
            $c = My::con();
            // select the categories that have on the parent column the value from $parent
            $com = $c->prepare("SELECT cf.*
                                             ,CASE
                                                WHEN (SELECT COUNT(*)
                                                      FROM categorias_financeira
                                                      WHERE categoria_mae = cf.id) > 0 THEN 'S'
                                                ELSE 'N'
                                             END flag_mae
                                       FROM categorias_financeira cf
                                       WHERE cf.`empresa_id` = ?
                                         AND cf.`categoria_mae` = ?");
            $com->bind_param("ii",
                $this->empresa_id,
                $parent);
            $com->execute();
            $r = $com->get_result();
            // show the categories one by one
            while ($l = $r->fetch_assoc()) {
                $output[] = $l;
                if ($l['id'] != $parent) {
                    // in case the current category's id is different that $parent
                    // we call our function again with new parameters
                    self::categoriasFinanceirasRecursivo($output, $l['id']);
                }
            }
            // return the list of categories
            return $output;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Função recursiva atual
     * */
    public function categoriasFinanceirasRecursivoV2(&$output = null, $parent = 1, $tipo_relatorio = 'S')
    {
        try {
            $c = My::con();
            // select the categories that have on the parent column the value from $parent
            $com = $c->prepare("CALL movimentacao_financeira_consulta2(?, ?, ?, ?, ?, ?, ?)");
            $com->bind_param("iiiisss",
                $this->empresa_id,
                $parent,
                $this->ano,
                $this->mes,
                $this->cancelado,
                $this->tipo,
                $tipo_relatorio);
            $com->execute();
            $r = $com->get_result();
            $c->next_result();
            while ($l = $r->fetch_assoc()) {
                $output[] = $l;
                if ($l['id'] != $parent) {
                    self::categoriasFinanceirasRecursivoV2($output, $l['id'], $tipo_relatorio);
                }
            }
            return $output;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
     * Verifica se categorias filhas tem alguma movimentação financeira
     * */
    public function verificaMovimentacaoFinanceiraPorCategoriaMae($cat_mae_id)
    {
        try {
            $c = My::con();
            $query = 'SELECT COUNT(*) TOTAL
                      FROM categorias_financeira CF
                      INNER JOIN movimentacao_financeira MF
                         ON CF.`id` = MF.`categoria_financeira_id`
                        AND CF.`empresa_id` = MF.`empresa_id`
                      WHERE CF.`empresa_id` = ?
                        AND YEAR(MF.`data`) = ?
                        AND MONTH(MF.`data`) = ?
                        AND CF.`categoria_mae` = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "iiii", $this->empresa_id,
                $this->ano,
                $this->mes,
                $cat_mae_id
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            if ($l['TOTAL'] > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaGeralPorTipoMovimentacao($tipo_movimentacao_financeira)
    {
        try {
            $c = My::con();
            $query = 'SELECT YEAR(MF.data) ano
                            ,MONTH(MF.data) mes
                            ,MF.categoria_financeira_id cat_id
                            ,CF.num cat_num
                            ,CF.nome cat_nome
                            ,CF.categoria_mae cat_mae_id
                            ,CM.num cat_mae_num
                            ,CM.nome cat_mae_nome
                            ,CASE
                              WHEN CF.tipo = \'R\' THEN \'Receitas\'
                              ELSE \'Despesas\'
                            END tipo
                            ,SUM(MF.valor) valor
                    FROM categorias_financeira CF
                    LEFT JOIN movimentacao_financeira MF
                        ON MF.categoria_financeira_id = CF.id
                    LEFT JOIN categorias_financeira CM
                       ON CF.categoria_mae = CM.id
                    WHERE MF.empresa_id = ?
                      AND YEAR(MF.data) = ?
                      AND MONTH(MF.data) = ?
                      AND IFNULL(CF.categoria_mae, \'\') <> \'\'
                      AND MF.cancelado = ?
                      AND MF.tipo = ?
                    GROUP BY YEAR(MF.data)
                            ,MONTH(MF.data)
                            ,MF.categoria_financeira_id
                            ,CF.num
                            ,CF.nome
                            ,CF.categoria_mae
                            ,CM.num
                            ,CM.nome
                            ,CF.tipo
                    ORDER BY CF.categoria_mae, MF.categoria_financeira_id';
            $com = $c->prepare($query);
            $com->bind_param("iiiss",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->cancelado,
                $tipo_movimentacao_financeira);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaGeralAnaliticoPorTipoMovimentacao($tipo_movimentacao_financeira)
    {
        try {
            $c = My::con();
            if ($tipo_movimentacao_financeira == 'S') {
                $query = "SELECT YEAR(MF.data) ano
                            ,MONTH(MF.data) mes
                            ,MF.categoria_financeira_id cat_id
                            ,CF.num cat_num
                            ,CF.nome cat_nome
                            ,CF.categoria_mae cat_mae_id
                            ,CM.num cat_mae_num
                            ,CM.nome cat_mae_nome
                            ,CASE
                                WHEN CF.tipo = 'R' THEN 'Receitas'
                                ELSE 'Despesas'
                             END tipo
                            ,MF.valor
                            ,MF.`data`
                      FROM categorias_financeira CF
                      LEFT JOIN movimentacao_financeira MF
                            ON MF.categoria_financeira_id = CF.id
                      LEFT JOIN categorias_financeira CM
                         ON CF.categoria_mae = CM.id
                      WHERE MF.empresa_id = ?
                        AND YEAR(MF.data) = ?
                        AND MONTH(MF.data) = ?
                        AND IFNULL(CF.categoria_mae, '') <> ''
                        AND MF.cancelado = ?
                        AND MF.tipo = ?
                      ORDER BY CF.categoria_mae
                              ,MF.categoria_financeira_id
                              ,MF.`data`";
            } else {
                $query = 'SELECT DISTINCT YEAR(MF.data) ano
                                         ,MONTH(MF.data) mes
                                         ,MF.categoria_financeira_id cat_id
                                         ,CF.num cat_num
                                         ,CF.nome cat_nome
                                         ,CF.categoria_mae cat_mae_id
                                         ,CM.num cat_mae_num
                                         ,CM.nome cat_mae_nome
                                         ,CASE
                                            WHEN CF.tipo = \'R\' THEN \'Receitas\'
                                            ELSE \'Despesas\'
                                          END tipo
                                         ,SUM(MF.valor) valor
                                         ,MF.`data`
                          FROM categorias_financeira CF
                          LEFT JOIN movimentacao_financeira MF
                             ON MF.categoria_financeira_id = CF.id
                          LEFT JOIN categorias_financeira CM
                             ON CF.categoria_mae = CM.id
                          WHERE MF.empresa_id = ?
                            AND YEAR(MF.data) = ?
                            AND MONTH(MF.data) = ?
                            AND IFNULL(CF.categoria_mae, \'\') <> \'\'
                            AND MF.cancelado = ?
                            AND MF.tipo = ?
                          GROUP BY MF.`data`
                                  ,MF.tipo
                                  ,MF.categoria_financeira_id
                                  ,CF.num
                                  ,CF.nome
                                 ,CF.categoria_mae
                          ORDER BY CF.categoria_mae
                                  ,MF.categoria_financeira_id
                                  ,MF.`data`';
            }
            $com = $c->prepare($query);
            $com->bind_param("iiiss",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->cancelado,
                $tipo_movimentacao_financeira);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaGeralPorCategoriaMae()
    {
        try {
            $c = My::con();
            $query = 'SELECT DISTINCT cfm.`id`
                                     ,cfm.`num` cat_mae_num
                                     ,cfm.`nome` cat_mae_nome
                     FROM movimentacao_financeira mf
                     INNER JOIN categorias_financeira cf
                             ON mf.`categoria_financeira_id` = cf.`id`
                            AND mf.`empresa_id` = cf.`empresa_id`
                     LEFT JOIN categorias_financeira cfm
                            ON cf.`categoria_mae` = cfm.`id`
                           AND cf.`empresa_id` = cfm.`empresa_id`
                     LEFT JOIN membros m
                            ON mf.`membro_id` = m.`id`
                     WHERE mf.empresa_id = ?
                       AND YEAR(`data`) = ?
                       AND MONTH(`data`) = ?
                       AND mf.tipo = ?
                       AND cancelado = ?';
            $com = $c->prepare($query);
            $com->bind_param("iiiss",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->tipo,
                $this->cancelado);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaGeralPorAnoMesMovimento()
    {
        try {
            $c = My::con();
            $query = "CALL relatorio_conselho_diretor(?,?,?,?)";
            $com = $c->prepare($query);
            $com->bind_param("iiis",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->tipo);
            $com->execute();
            $r = $com->get_result();
            $c->next_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaPorCategoriaMaeId($categoria_mae_id, $tipo_resumo)
    {
        try {
            $c = My::con();
            if ($tipo_resumo === 'S') {
                $query = 'SELECT cf.`nome`
                            ,SUM(mf.`valor`) valor
                      FROM movimentacao_financeira mf
                      INNER JOIN categorias_financeira cf
                        ON mf.`categoria_financeira_id` = cf.`id`
                       AND mf.`empresa_id` = cf.`empresa_id`
                      LEFT JOIN categorias_financeira cfm
                        ON cf.`categoria_mae` = cfm.`id`
                       AND cf.`empresa_id` = cfm.`empresa_id`
                      LEFT JOIN membros m
                        ON mf.`membro_id` = m.`id`
                      WHERE mf.empresa_id = ?
                        AND YEAR(mf.`data`) = ?
                        AND MONTH(mf.`data`) = ?
                        AND mf.tipo = ?
                        AND IFNULL(mf.cancelado,\'N\') = ?
                        AND cf.`categoria_mae` = ?
                      GROUP BY cf.`nome`
                      ORDER BY cf.`nome`';
            } else {
                $query = 'SELECT cf.`nome`
                                ,mf.`valor`
                                ,m.`nome` membro_nome
                                ,mf.`descricao`
                          FROM movimentacao_financeira mf
                          INNER JOIN categorias_financeira cf
                            ON mf.`categoria_financeira_id` = cf.`id`
                           AND mf.`empresa_id` = cf.`empresa_id`
                          LEFT JOIN categorias_financeira cfm
                            ON cf.`categoria_mae` = cfm.`id`
                           AND cf.`empresa_id` = cfm.`empresa_id`
                          LEFT JOIN membros m
                            ON mf.`membro_id` = m.`id`
                          WHERE mf.empresa_id = ?
                            AND YEAR(mf.`data`) = ?
                            AND MONTH(mf.`data`) = ?
                            AND mf.tipo = ?
                            AND IFNULL(mf.cancelado,\'N\') = ?
                            AND cf.`categoria_mae` = ?
                          ORDER BY cf.`nome`';
            }
            $com = $c->prepare($query);
            $com->bind_param("iiissi",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->tipo,
                $this->cancelado,
                $categoria_mae_id);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaGeral()
    {
        try {
            $c = My::con();
            $query = 'SELECT DISTINCT 
                             mf.`categoria_financeira_id`
							,cf.`num`
							,cf.`nome`
							,cfm.`num` cat_mae_num
							,cfm.`nome` cat_mae_nome
                     FROM movimentacao_financeira mf
                     INNER JOIN categorias_financeira cf
                        ON mf.`categoria_financeira_id` = cf.`id`
                       AND mf.`empresa_id` = cf.`empresa_id`
                     LEFT JOIN categorias_financeira cfm
                        ON cf.`categoria_mae` = cfm.`id`
                       AND cf.`empresa_id` = cfm.`empresa_id`
                     LEFT JOIN membros m
                        ON mf.`membro_id` = m.`id`
                     WHERE mf.empresa_id = ?
                       AND YEAR(`data`) = ?
                       AND MONTH(`data`) = ?
                       AND mf.tipo = ?
                       AND cancelado = ?';
            $com = $c->prepare($query);
            $com->bind_param("iiiss",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->tipo,
                $this->cancelado);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function caixaPorCategoriaFinanceira($categoria_financeira_id)
    {
        try {
            $c = My::con();
            $query = 'SELECT mf.`valor`
                            ,m.`nome` membro_nome
                            ,mf.`descricao`
                     FROM movimentacao_financeira mf
                     INNER JOIN categorias_financeira cf
                        ON mf.`categoria_financeira_id` = cf.`id`
                       AND mf.`empresa_id` = cf.`empresa_id`
                     LEFT JOIN categorias_financeira cfm
                        ON cf.`categoria_mae` = cfm.`id`
                       AND cf.`empresa_id` = cfm.`empresa_id`
                     LEFT JOIN membros m
                        ON mf.`membro_id` = m.`id`
                     WHERE mf.empresa_id = ?
                       AND YEAR(`data`) = ?
                       AND MONTH(`data`) = ?
                       AND mf.tipo = ?
                       AND cancelado = ?
                       AND mf.`categoria_financeira_id` = ?';
            $com = $c->prepare($query);
            $com->bind_param("iiissi",
                $this->empresa_id,
                $this->ano,
                $this->mes,
                $this->tipo,
                $this->cancelado,
                $categoria_financeira_id);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * @param mixed $cancelado
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @return mixed
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param mixed $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }
}