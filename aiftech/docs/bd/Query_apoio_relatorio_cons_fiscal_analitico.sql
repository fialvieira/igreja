/****************************ANALÍTICO**************************************/
SELECT DISTINCT MF.categoria_financeira_id cat_id
							 ,CF.num cat_num
							 ,CF.nome cat_nome
							 ,CF.categoria_mae cat_mae_id
							 ,CM.num cat_mae_num
							 ,CM.nome cat_mae_nome
							 ,CASE
									WHEN CF.tipo = 'R' THEN 'Receitas'
									ELSE 'Despesas'
								END tipo
							 ,SUM(MF.valor) valor
							 ,MF.`data`
FROM categorias_financeira CF
LEFT JOIN movimentacao_financeira MF
		ON MF.categoria_financeira_id = CF.id
LEFT JOIN categorias_financeira CM
	 ON CF.categoria_mae = CM.id
WHERE MF.empresa_id = 1
	AND YEAR(MF.data) = 2018
	AND MONTH(MF.data) = 8
	AND IFNULL(CF.categoria_mae, '') <> ''
	AND MF.cancelado = 'N'
	AND MF.tipo = 'S'
GROUP BY MF.`data`
				,MF.tipo
				,MF.categoria_financeira_id
				,CF.num
				,CF.nome
				,CF.categoria_mae
ORDER BY CF.categoria_mae
			  ,MF.categoria_financeira_id
			  ,MF.`data`