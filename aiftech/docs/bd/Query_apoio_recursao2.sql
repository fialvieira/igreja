/*
    CALL movimentacao_financeira_consulta2(1, 2, 2018, 8, 'N', 'E', 'S');
*/

/*    
DECLARE
    @tab TABLE(ano INT, mes INT, id INT(11), num VARCHAR(10), nome VARCHAR(100), cat_mae_id INT(11), cat_mae_num VARCHAR(10), cat_mae_nome VARCHAR(100), tipo VARCHAR(70), flag_mae CHAR(1), `data` DATE, valor DECIMAL(10,2));
*/

DROP TABLE IF EXISTS `temp`;

CREATE TEMPORARY TABLE temp
SELECT CASE
            WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = 2018 AND MONTH(TBL.data) < 8) THEN NULL
            ELSE TBL.ano
       END ano
      ,CASE
            WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = 2018 AND MONTH(TBL.data) < 8) THEN NULL
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
            WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = 2018 AND MONTH(TBL.data) < 8) THEN NULL
            ELSE TBL.`data`
       END `data`
      ,CASE
            WHEN  (TBL.flag_mae = 'S') AND (YEAR(TBL.data) = 2018 AND MONTH(TBL.data) < 8) THEN NULL
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
WHERE CF.`empresa_id` = 1
  AND IFNULL(CF.`categoria_mae`, '') = CASE IFNULL(1, '')
                                          WHEN '' THEN ''
                                          ELSE 1
                                       END
  AND IFNULL(MF.cancelado, '') = CASE IFNULL(MF.cancelado, '')
                                    WHEN '' THEN ''
                                    ELSE 'N'
                                 END
  AND IFNULL(MF.tipo, '') = CASE IFNULL(MF.tipo, '')
                                WHEN '' THEN ''
                                ELSE 'E'
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
                                     ELSE 2018
                                   END
  AND IFNULL(MONTH(MF.data), '') = CASE IFNULL(MONTH(MF.data), '')
                                      WHEN '' THEN ''
                                      ELSE 8
                                    END
GROUP BY YEAR(MF.data)
        ,MONTH(MF.data)
        ,MF.id
        ,MF.num
        ,MF.nome
        ,MF.cat_mae_id
        ,MF.cat_mae_num
        ,MF.cat_mae_nome
        ,MF.tipo