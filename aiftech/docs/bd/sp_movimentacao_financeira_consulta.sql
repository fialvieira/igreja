DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_consulta`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_consulta`(
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
        SELECT TBL.*
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
              ,SUM(MF.valor) valor
        FROM categorias_financeira CF
        LEFT JOIN movimentacao_financeira MF
            ON CF.id = MF.categoria_financeira_id
        LEFT JOIN categorias_financeira CM
           ON CF.categoria_mae = CM.id
        WHERE CF.`empresa_id` = vempresa
          AND IFNULL(CF.`categoria_mae`, '') = CASE IFNULL(vcat_mae, '')
                                                  WHEN '' THEN ''
                                                  ELSE vcat_mae
                                               END
          AND IFNULL(YEAR(MF.data), '') = CASE IFNULL(YEAR(MF.data), '')
                                            WHEN '' THEN ''
                                            ELSE vano
                                          END
          AND IFNULL(MONTH(MF.data), '') = CASE IFNULL(MONTH(MF.data), '')
                                             WHEN '' THEN ''
                                             ELSE vmes
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
                       END
         GROUP BY YEAR(MF.data)
                 ,MONTH(MF.data)
                 ,IFNULL(MF.categoria_financeira_id, CF.id)
                 ,CF.num
                 ,CF.nome
                 ,CF.categoria_mae
                 ,CM.num
                 ,CM.nome
                 ,CF.tipo
          ) TBL
        WHERE 1 = 1
          AND CASE
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NULL THEN TBL.valor IS NULL
                WHEN TBL.flag_mae = 'S' AND TBL.valor IS NOT NULL THEN TBL.valor IS NOT NULL
                WHEN TBL.flag_mae = 'N' THEN TBL.valor IS NOT NULL
              END;
    END IF;
    
END$$

DELIMITER ;