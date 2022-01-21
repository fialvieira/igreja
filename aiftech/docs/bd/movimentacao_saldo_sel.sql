DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_saldo_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_saldo_sel`(
	vempresa INT(11),
	vtipo CHAR(1),
	vcancelado CHAR(1),
	vdt_ini DATE,
	vdt_fim DATE
)
BEGIN
	SELECT MS.*
				,CFO.`nome` CF_ORIGEM
				,BO.`nome` BANCO_ORIGEM
				,CFD.`nome` CF_DESTINO
				,BD.`nome` BANCO_DESTINO
				,CASE
					WHEN MS.tipo = 'S' THEN 'Débito'
					ELSE 'Crédito'
				 END TIPO_DESCRICAO
		FROM movimentacao_saldo MS
		LEFT JOIN contas_financeira CFO
			ON MS.`contas_financ_origem_id` = CFO.`id`
		 AND MS.`empresa_id` = CFO.`empresa_id`
		LEFT JOIN bancos BO
			ON CFO.`banco_id` = BO.`id`
		LEFT JOIN contas_financeira CFD
			ON MS.`contas_financ_destino_id` = CFD.`id`
		 AND MS.`empresa_id` = CFD.`empresa_id`
		LEFT JOIN bancos BD
			ON CFD.`banco_id` = BD.`id`
			WHERE MS.empresa_id = vempresa
				AND MS.data BETWEEN vdt_ini AND vdt_fim
				AND MS.tipo = IFNULL(vtipo, MS.tipo)
				AND IFNULL(MS.cancelado,'N') = CASE IFNULL(vcancelado,'')
																					 WHEN '' THEN IFNULL(MS.cancelado,'N')
																					 ELSE vcancelado
																				END
			ORDER BY MS.id, MS.data DESC;																	
END$$

DELIMITER ;