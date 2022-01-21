DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `get_lancamentos_categorias_mae`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_lancamentos_categorias_mae`(
	vempresa INT(11),
	vativo CHAR(1),
	vdata DATE
)
BEGIN
	SELECT TBL.* 
	FROM (SELECT MF.*, CF.num, CF.nome categoria, fn_sort_number(CF.num) numero_categoria,
	             CC.descricao centro_custo, M.nome contribuinte, CONCAT(COF.nome, ' - ', B.nome) conta_financeira
				FROM movimentacao_financeira MF
				INNER JOIN categorias_financeira CF
					 ON CF.id = MF.categoria_financeira_id
				LEFT JOIN centro_custo CC
					 ON MF.centro_custo_id = CC.id
				LEFT JOIN membros M
					 ON MF.membro_id = M.id
				LEFT JOIN contas_financeira COF
					 ON MF.contas_financeira_id = COF.id
				LEFT JOIN bancos B
					 ON COF.banco_id = B.id
				WHERE MF.empresa_id = vempresa
				--	AND MF.data >=  (DATE_FORMAT(vdata ,'%Y-%m-01'))
					AND MF.data >= vdata
			-- 		AND IFNULL(MF.cancelado,'N') <> 'S'
					AND CF.ativo = vativo
					AND CF.categoria_mae IS NULL  
				UNION
				SELECT MF.*, CF.num, CF.nome categoria, fn_sort_number(CF.num) numero_categoria,
	             CC.descricao centro_custo, M.nome contribuinte, CONCAT(COF.nome, ' - ', B.nome) conta_financeira
				FROM movimentacao_financeira MF
				INNER JOIN categorias_financeira CF
					ON CF.id = MF.categoria_financeira_id
				LEFT JOIN centro_custo CC
					 ON MF.centro_custo_id = CC.id
				LEFT JOIN membros M
					 ON MF.membro_id = M.id
				LEFT JOIN contas_financeira COF
					 ON MF.contas_financeira_id = COF.id
				LEFT JOIN bancos B
					 ON COF.banco_id = B.id
				WHERE MF.empresa_id = vempresa
				--	AND MF.data >=  (DATE_FORMAT(vdata ,'%Y-%m-01'))
					AND MF.data >= vdata
			-- 		AND IFNULL(MF.cancelado,'N') <> 'S'
					AND IFNULL(CF.ativo,'') = CASE IFNULL(vativo,'')
																			WHEN '' THEN IFNULL(CF.ativo,'')
																			ELSE vativo
																		END
					AND CF.id IN (SELECT DISTINCT categoria_mae
														FROM categorias_financeira
														WHERE empresa_id = MF.empresa_id
															AND IFNULL(ativo,'') = CASE IFNULL(vativo,'')
																											 WHEN '' THEN IFNULL(ativo,'')
																											 ELSE vativo
																										 END
															AND categoria_mae IS NOT NULL)) TBL
	ORDER BY TBL.numero_categoria, TBL.data;
END$$

DELIMITER ;