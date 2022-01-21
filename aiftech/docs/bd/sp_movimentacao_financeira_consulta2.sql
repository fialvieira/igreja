DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_consulta2`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_consulta2`(
	vempresa    INT(11),
	vcat_mae    INT(11) UNSIGNED,
	vano        INT,
	vmes        INT,
	vcancelado  CHAR(1),
	vtipo_mf    CHAR(1),
	vtipo_rel   CHAR(1) /**(A)nalítico, (S)intético**/
)
BEGIN
    IF vtipo_rel = 'S' THEN
        DROP TABLE IF EXISTS `temp`;
        CREATE TEMPORARY TABLE temp
        SELECT CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.ano
               END ano
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.mes
               END mes
              ,TBL.id
              ,TBL.num
              ,TBL.nome
              ,TBL.cat_mae_id
              ,TBL.cat_mae_num
              ,TBL.cat_mae_nome
              ,TBL.tipo
              ,TBL.flag_mae
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.`data`
               END `data`
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.valor
               END valor
        FROM
        (SELECT YEAR(MF.data) ano
              ,MONTH(MF.data) mes
              ,IFNULL(MF.categoria_financeira_id, CF.id) id
              ,CF.num
              ,CF.nome
              ,CF.categoria_mae cat_mae_id
              ,CM.num cat_mae_num
              ,CM.nome cat_mae_nome
              ,CASE
                WHEN CF.tipo = 'R'
                THEN 'Receitas'
                ELSE 'Despesas'
               END tipo
              ,CASE
                WHEN (SELECT COUNT(*)
                      FROM categorias_financeira
                      WHERE categoria_mae = CF.id) > 0 THEN 'S'
                ELSE 'N'
               END flag_mae
              ,MF.`data`
              ,MF.valor
        FROM categorias_financeira CF
        LEFT JOIN movimentacao_financeira MF
            ON CF.id = MF.categoria_financeira_id
           AND CF.empresa_id = MF.empresa_id
        LEFT JOIN categorias_financeira CM
           ON CF.categoria_mae = CM.id
          AND CF.empresa_id = CM.empresa_id
        WHERE CF.`empresa_id` = vempresa
          AND IFNULL(CF.`categoria_mae`, '') = CASE IFNULL(vcat_mae, '')
                                                  WHEN '' THEN ''
                                                  ELSE vcat_mae
                                               END
          AND IFNULL(MF.cancelado, '') = CASE IFNULL(MF.cancelado, '')
                                            WHEN '' THEN ''
                                            ELSE vcancelado
                                         END
          AND IFNULL(MF.tipo, '') = CASE IFNULL(MF.tipo, '')
                                        WHEN '' THEN ''
                                        ELSE vtipo_mf
                                    END
          AND CF.tipo = CASE
                        WHEN vtipo_mf = 'E' THEN 'R'
                        ELSE 'D'
                       END) TBL
        WHERE 1 = 1
          AND CASE
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NULL THEN TBL.valor IS NULL
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NOT NULL THEN TBL.valor IS NOT NULL
                WHEN TBL.flag_mae = 'N' THEN TBL.valor IS NOT NULL 
              END;
        SELECT MF.ano
              ,MF.mes
              ,MF.id
              ,MF.num
              ,fn_sort_number(MF.num) numero
              ,MF.nome
              ,MF.cat_mae_id
              ,MF.cat_mae_num
              ,MF.cat_mae_nome
              ,MF.tipo
              ,MF.flag_mae
              ,MF.data
              ,SUM(MF.valor) valor
        FROM temp MF
        WHERE 1 = 1
          AND IFNULL(YEAR(MF.data), '') = CASE IFNULL(YEAR(MF.data), '')
                                             WHEN '' THEN ''
                                             ELSE vano
                                           END
          AND IFNULL(MONTH(MF.data), '') = CASE IFNULL(MONTH(MF.data), '')
                                              WHEN '' THEN ''
                                              ELSE vmes
                                            END
        GROUP BY MF.ano
                ,MF.mes
                ,MF.id
                ,MF.num
                ,MF.nome
                ,MF.cat_mae_id
                ,MF.cat_mae_num
                ,MF.cat_mae_nome
                ,MF.tipo;
    ELSE
	DROP TABLE IF EXISTS `temp`;
        CREATE TEMPORARY TABLE temp
        SELECT CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.ano
               END ano
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.mes
               END mes
              ,TBL.id
              ,TBL.num
              ,TBL.nome
              ,TBL.cat_mae_id
              ,TBL.cat_mae_num
              ,TBL.cat_mae_nome
              ,TBL.tipo
              ,TBL.flag_mae
              ,TBL.descricao
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.`data`
               END `data`
              ,CASE
                    WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = vano AND MONTH(TBL.data) < vmes) THEN NULL
                    ELSE TBL.valor
               END valor
        FROM
        (SELECT YEAR(MF.data) ano
              ,MONTH(MF.data) mes
              ,IFNULL(MF.categoria_financeira_id, CF.id) id
              ,CF.num
              ,CF.nome
              ,CF.categoria_mae cat_mae_id
              ,CM.num cat_mae_num
              ,CM.nome cat_mae_nome
              ,CASE
                WHEN CF.tipo = 'R'
                THEN 'Receitas'
                ELSE 'Despesas'
               END tipo
              ,CASE
                WHEN (SELECT COUNT(*)
                      FROM categorias_financeira
                      WHERE categoria_mae = CF.id) > 0 THEN 'S'
                ELSE 'N'
               END flag_mae
              ,MF.`descricao`
              ,MF.`data`
              ,MF.valor
        FROM categorias_financeira CF
        LEFT JOIN movimentacao_financeira MF
            ON CF.id = MF.categoria_financeira_id
           AND CF.empresa_id = MF.empresa_id
        LEFT JOIN categorias_financeira CM
           ON CF.categoria_mae = CM.id
          AND CF.empresa_id = CM.empresa_id
        WHERE CF.`empresa_id` = vempresa
          AND IFNULL(CF.`categoria_mae`, '') = CASE IFNULL(vcat_mae, '')
                                                  WHEN '' THEN ''
                                                  ELSE vcat_mae
                                               END
          AND IFNULL(MF.cancelado, '') = CASE IFNULL(MF.cancelado, '')
                                            WHEN '' THEN ''
                                            ELSE vcancelado
                                         END
          AND IFNULL(MF.tipo, '') = CASE IFNULL(MF.tipo, '')
                                        WHEN '' THEN ''
                                        ELSE vtipo_mf
                                    END
          AND CF.tipo = CASE
                        WHEN vtipo_mf = 'E' THEN 'R'
                        ELSE 'D'
                       END) TBL
        WHERE 1 = 1
          AND CASE
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NULL THEN TBL.valor IS NULL
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NOT NULL THEN TBL.valor IS NOT NULL
                WHEN TBL.flag_mae = 'N' THEN TBL.valor IS NOT NULL 
              END;
              
        SELECT MF.ano
              ,MF.mes
              ,MF.id
              ,MF.num
              ,fn_sort_number(MF.num) numero
              ,MF.nome
              ,MF.cat_mae_id
              ,MF.cat_mae_num
              ,MF.cat_mae_nome
              ,MF.tipo
              ,MF.flag_mae
              ,MF.descricao
              ,MF.data
              ,MF.valor
        FROM temp MF
        WHERE 1 = 1
          AND IFNULL(YEAR(MF.data), '') = CASE IFNULL(YEAR(MF.data), '')
                                             WHEN '' THEN ''
                                             ELSE vano
                                           END
          AND IFNULL(MONTH(MF.data), '') = CASE IFNULL(MONTH(MF.data), '')
                                              WHEN '' THEN ''
                                              ELSE vmes
                                            END
        /*GROUP BY MF.ano
                ,MF.mes
                ,MF.id
                ,MF.num
                ,MF.nome
                ,MF.cat_mae_id
                ,MF.cat_mae_num
                ,MF.cat_mae_nome
                ,MF.tipo*/;
    END IF;
    
END$$

DELIMITER ;