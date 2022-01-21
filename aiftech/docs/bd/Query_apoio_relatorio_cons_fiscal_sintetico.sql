/*********SINTÉTICO*************/
SELECT YEAR(MF.data) ano
      ,MONTH(MF.data) mes
      ,MF.categoria_financeira_id cat
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
      ,SUM(MF.valor) valor
FROM categorias_financeira CF
LEFT JOIN movimentacao_financeira MF
    ON MF.categoria_financeira_id = CF.id
LEFT JOIN categorias_financeira CM
   ON CF.categoria_mae = CM.id
WHERE MF.empresa_id = 1
  AND YEAR(MF.data) = 2018
  AND MONTH(MF.data) = 8
  AND IFNULL(MF.cancelado, 'N') <> 'S'
  AND MF.tipo = 'E'
GROUP BY YEAR(MF.data)
        ,MONTH(MF.data)
        ,MF.categoria_financeira_id
        ,CF.num
        ,CF.nome
        ,CF.categoria_mae
        ,CM.num
        ,CM.nome
        ,CF.tipo
ORDER BY CF.categoria_mae
        ,MF.categoria_financeira_id;

