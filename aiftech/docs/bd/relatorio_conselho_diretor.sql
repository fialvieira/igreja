DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `relatorio_conselho_diretor`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `relatorio_conselho_diretor`(
	vempresa	INT(11),
	vano 			INT,
	vmes 			INT,
	vtipo			CHAR(1)
)
BEGIN
	SELECT tbl.*
	FROM (
		SELECT DISTINCT
					 C.id
					,C.num
					,C.nome
					,CM.id mae
					/*,CASE WHEN C.tipo = 'R' THEN 'Receitas' 
								ELSE 'Despesas' 
					 END tipo*/
					,C.tipo
					,(SELECT SUM(valor) valor
						FROM movimentacao_financeira
						WHERE empresa_id = C.empresa_id
							AND IFNULL(cancelado, 'N') <> 'S'
							AND YEAR(`data`) = YEAR(mf.`data`)
							AND MONTH(`data`) = MONTH(mf.`data`)
							AND categoria_financeira_id = C.id
						GROUP BY YEAR(`data`), MONTH(`data`), categoria_financeira_id) valor_realizado
					,'N' flag_mae
		FROM categorias_financeira C
		LEFT JOIN categorias_financeira CM
			ON C.categoria_mae = CM.id
		 AND C.empresa_id = CM.empresa_id
		INNER JOIN movimentacao_financeira mf
			ON C.id = mf.categoria_financeira_id
		WHERE C.empresa_id = vempresa
		  AND C.categoria_mae IS NOT NULL
		  AND YEAR(mf.`data`) = vano
		  AND MONTH(mf.`data`) = vmes
			
		UNION ALL													
		
		SELECT CM.id
					,CM.num
					,CM.nome
					,CMM.id mae
					/*,CASE WHEN CM.tipo = 'R' THEN 'Receitas' 
								ELSE 'Despesas' 
					 END tipo*/
					 ,CM.`tipo`
					,(SELECT SUM(mf.valor)
						FROM movimentacao_financeira mf
						LEFT JOIN categorias_financeira cf
							ON mf.categoria_financeira_id = cf.id
						 AND mf.empresa_id = cf.empresa_id	
						LEFT JOIN categorias_financeira cfm
							ON cf.categoria_mae = cfm.id
						 AND cf.empresa_id = cfm.empresa_id	
						WHERE mf.empresa_id = C.empresa_id
							AND IFNULL(mf.cancelado, 'N') <> 'S'
							AND YEAR(mf.`data`) = vano
							AND MONTH(mf.`data`) = vmes
							AND cfm.id = CM.id
						GROUP BY YEAR(mf.`data`), MONTH(mf.`data`), cfm.id) valor_realizado
					,'S' flag_mae
		FROM categorias_financeira C
		LEFT JOIN categorias_financeira CM
			ON C.categoria_mae = CM.id
		LEFT JOIN categorias_financeira CMM
			ON CM.categoria_mae = CMM.id
		WHERE C.empresa_id = vempresa
			/*AND CM.id IS NOT NULL*/
		GROUP BY CM.num, CM.nome, CM.tipo
	)	tbl
	WHERE tbl.tipo = CASE 
										WHEN IFNULL(vtipo, '') = '' THEN tbl.tipo
										WHEN IFNULL(vtipo, '') = 'E' THEN 'R'
										WHEN IFNULL(vtipo, '') = 'S' THEN 'D'
									 END
	ORDER BY tbl.tipo DESC, tbl.num;
  
END$$

DELIMITER ;