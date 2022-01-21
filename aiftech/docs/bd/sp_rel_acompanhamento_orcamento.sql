DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `rel_acompanhamento_orcamento`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `rel_acompanhamento_orcamento`(
	vempresa INT(11),
	vano CHAR(4),
	vmes CHAR(2)
)
BEGIN
	SELECT tbl.*
	FROM (
		SELECT O.ano
					,O.mes
					,O.categoria_id id
					,C.num
					,C.nome
					,CM.id mae
					,CASE WHEN C.tipo = 'R' THEN 'Receitas' 
								ELSE 'Despesas' 
					 END tipo
					,O.valor_previsto 
					,(SELECT SUM(valor) valor
						FROM movimentacao_financeira
						WHERE empresa_id = O.empresa_id
							AND IFNULL(cancelado,'N') <> 'S'
							AND YEAR(`data`) = O.ano
							AND MONTH(`data`) = O.mes
							AND categoria_financeira_id = O.categoria_id
						GROUP BY YEAR(`data`), MONTH(`data`), categoria_financeira_id) valor_realizado
					,'N' flag_mae
		FROM orcamento O
		LEFT JOIN categorias_financeira C
			ON O.categoria_id = C.id
		LEFT JOIN categorias_financeira CM
			ON C.categoria_mae = CM.id
		WHERE O.empresa_id = vempresa
			AND O.ano = vano
			AND O.mes = IFNULL(vmes,O.mes)
			
		UNION ALL													
		
		SELECT O.ano
					,O.mes
					,CM.id 
					,CM.num
					,CM.nome
					,CMM.id mae
					,CASE WHEN CM.tipo = 'R' THEN 'Receitas' 
								ELSE 'Despesas' 
					 END tipo
					,SUM(O.valor_previsto) valor_previsto
					,(SELECT SUM(t1.valor)
						FROM movimentacao_financeira t1
						LEFT JOIN categorias_financeira t2
							ON t1.categoria_financeira_id = t2.id
						 AND t1.empresa_id = t2.empresa_id	
						LEFT JOIN categorias_financeira t3
							ON t2.categoria_mae = t3.id
						 AND t2.empresa_id = t2.empresa_id	
						WHERE t1.empresa_id = 1
							AND IFNULL(t1.cancelado,'N') <> 'S'
							AND YEAR(t1.`data`) = O.ano
							AND MONTH(t1.`data`) = O.mes
							AND t3.id = CM.id
						GROUP BY YEAR(t1.`data`), MONTH(t1.`data`), t3.id) valor_realizado
					,'S' flag_mae
		FROM orcamento O
		LEFT JOIN categorias_financeira C
			ON O.categoria_id = C.id
		LEFT JOIN categorias_financeira CM
			ON C.categoria_mae = CM.id
		LEFT JOIN categorias_financeira CMM
			ON CM.categoria_mae = CMM.id
		WHERE O.empresa_id = vempresa
			AND O.ano = vano
			AND O.mes = IFNULL(vmes,O.mes)
			AND CM.id IS NOT NULL
		GROUP BY O.ano, O.mes, CM.id, CM.num, CM.nome, CM.tipo
	)	tbl
	ORDER BY tbl.tipo DESC, tbl.num, tbl.ano, tbl.mes;
  
END$$

DELIMITER ;