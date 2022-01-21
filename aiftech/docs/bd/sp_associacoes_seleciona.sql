DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `associacoes_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `associacoes_seleciona`(
	vempresa 	INT(11),
	vativo	 	CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM associacoes T1
	WHERE T1.empresa_id = vempresa
	  AND IFNULL(T1.ativo, '') = CASE IFNULL(vativo, '')
																 WHEN '' THEN T1.ativo
																 ELSE vativo
															 END
	ORDER BY T1.sigla;
END$$

DELIMITER ;