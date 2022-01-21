DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT T1.*, T2.nome membro_nome, CONCAT(T3.descricao, ' - ', T4.nome) conta_financeira
	FROM movimentacao_financeira T1
	LEFT JOIN membros T2
		ON T1.membro_id = T2.id
	LEFT JOIN contas_financeira T3
		ON T1.contas_financeira_id = T3.id
	LEFT JOIN bancos T4
		ON T3.banco_id = T4.id
	WHERE T1.id = vid; 
END$$

DELIMITER ;