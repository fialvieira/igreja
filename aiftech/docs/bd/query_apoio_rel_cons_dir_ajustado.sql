/*Resumo por categoria mãe*/
SELECT DISTINCT cfm.`id`
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
 WHERE mf.empresa_id = 1
	 AND YEAR(`data`) = 2018
	 AND MONTH(`data`) = 8
	 AND mf.tipo = 'E'
	 AND cancelado = 'N'
/*Detalhamento das contas - Analítico*/	 
SELECT cf.`nome`
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
WHERE mf.empresa_id = 1
 AND YEAR(`data`) = 2018
 AND MONTH(`data`) = 8
 AND mf.tipo = 'E'
 AND cancelado = 'N'
 AND cf.`categoria_mae` = 1
ORDER BY cf.`nome`
/*Detalhamento das contas - Sintético*/	 
SELECT cf.`nome`
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
WHERE mf.empresa_id = 1
 AND YEAR(`data`) = 2018
 AND MONTH(`data`) = 8
 AND mf.tipo = 'E'
 AND cancelado = 'N'
 AND cf.`categoria_mae` = 1
GROUP BY cf.`nome`
ORDER BY cf.`nome`