/*
    CALL movimentacao_financeira_consulta(1, 1, 2018, 8, 'N', 'E', 'S');
*/
SELECT TBL.*
FROM
(SELECT YEAR(MF.data) ano
      ,MONTH(MF.data) mes
      ,IFNULL(MF.categoria_financeira_id, CF.id) id
      ,CF.num
      ,CF.nome
      ,CF.categoria_mae mae
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
   AND CF.empresa_id = MF.empresa_id
LEFT JOIN categorias_financeira CM
   ON CF.categoria_mae = CM.id
  AND CF.empresa_id = CM.empresa_id
WHERE CF.`empresa_id` = 1
  AND IFNULL(CF.`categoria_mae`, '') = CASE IFNULL(1, '')
                                          WHEN '' THEN ''
                                          ELSE 1
                                       END
  AND IFNULL(YEAR(MF.data), '') = CASE IFNULL(YEAR(MF.data), '')
                                    WHEN '' THEN ''
                                    ELSE 2018
                                  END
  AND IFNULL(MONTH(MF.data), '') = CASE IFNULL(MONTH(MF.data), '')
                                     WHEN '' THEN ''
                                     ELSE 8
                                   END
  AND IFNULL(MF.cancelado, '') = CASE IFNULL(MF.cancelado, '')
                                    WHEN '' THEN ''
                                    ELSE 'N'
                                 END
  AND IFNULL(MF.tipo, '') = CASE IFNULL(MF.tipo, '')
                                WHEN '' THEN ''
                                ELSE 'E'
                            END
 GROUP BY YEAR(MF.data)
         ,MONTH(MF.data)
         ,IFNULL(MF.categoria_financeira_id, CF.id)
         ,CF.num
         ,CF.nome
         ,CF.categoria_mae
         ,CM.num
         ,CM.nome
         ,CF.tipo) TBL
WHERE 1 = 1
  AND CASE
        WHEN TBL.flag_mae = 'S' AND TBL.valor IS NULL THEN TBL.valor IS NULL
        WHEN TBL.flag_mae = 'S' AND TBL.valor IS NOT NULL THEN TBL.valor IS NOT NULL
        WHEN TBL.flag_mae = 'N' THEN TBL.valor IS NOT NULL 
      END
