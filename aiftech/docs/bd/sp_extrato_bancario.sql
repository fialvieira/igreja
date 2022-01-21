DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `extrato_bancario`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `extrato_bancario`(
	vempresa INT(11),
	vconta INT,
	vdt_ini DATE,
	vdt_fim DATE
)
BEGIN
	SELECT MS.id
				,MS.data
	      ,MS.descricao
	      ,MS.valor
	      ,MS.saldo
	      ,CASE WHEN MS.tipo = 'E' THEN 'C'
						  ELSE 'D'
				 END tipo
				,CONCAT(CF.nome,' - Ag. ',CF.agencia,' - C/C ',CF.numero) conta
				,MS.movimentacao_financeira_id mov_financeira
	FROM movimentacao_saldo MS
	INNER JOIN contas_financeira CF
		ON MS.conta_financ_id = CF.id
	 AND MS.empresa_id = CF.empresa_id
	WHERE MS.empresa_id = vempresa
		AND MS.conta_financ_id = vconta
		AND MS.data BETWEEN vdt_ini AND vdt_fim;
--	ORDER BY MS.data;																	
END$$

DELIMITER ;