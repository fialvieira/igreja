DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_sel`(
	vempresa INT(11),
	vtipo CHAR(1),
	vcancelado CHAR(1),
	vdt_ini DATE,
	vdt_fim DATE
)
BEGIN
	SELECT T1.*, T2.nome categoria_financeira, T3.descricao centro_custo, T4.nome contribuinte, CONCAT(T5.nome, ' - ', T6.nome) conta_financeira
	FROM movimentacao_financeira T1
	LEFT JOIN categorias_financeira T2
		   ON T1.categoria_financeira_id = T2.id
	LEFT JOIN centro_custo T3
		   ON T1.centro_custo_id = T3.id
	LEFT JOIN membros T4
		   ON T1.membro_id = T4.id
	LEFT JOIN contas_financeira T5
		ON T1.contas_financeira_id = T5.id
	LEFT JOIN bancos T6
		ON T5.banco_id = T6.id
	WHERE T1.empresa_id = vempresa
	  AND T1.data BETWEEN vdt_ini AND vdt_fim
	  AND T1.tipo = CASE IFNULL(vtipo,'')
											WHEN '' THEN T1.tipo
											ELSE vtipo
										END
	  AND IFNULL(T1.cancelado,'N') = CASE IFNULL(vcancelado,'')
																			 WHEN '' THEN IFNULL(T1.cancelado,'N')
																			 ELSE vcancelado
																		END
	ORDER BY T1.tipo, T1.data DESC;																	
END$$

DELIMITER ;