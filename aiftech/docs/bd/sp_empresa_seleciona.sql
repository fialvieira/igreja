DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `empresa_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_seleciona`(
	vid INT(11)
)
BEGIN
	SELECT E.*, EP.pastor_id, P.nome pastor, A.sigla
	FROM empresas E
	LEFT JOIN assoc_empresas_pastores EP
		ON E.id = EP.empresa_id
	 AND EP.categoria = 'T'
	LEFT JOIN pastores P
		ON EP.pastor_id = P.id
	LEFT JOIN associacoes A
	  ON E.associacao_id = A.id	
	WHERE E.id = vid;
END$$

DELIMITER ;