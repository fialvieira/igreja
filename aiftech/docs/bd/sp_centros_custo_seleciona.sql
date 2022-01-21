DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `centros_custo_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `centros_custo_seleciona`(
  vativo CHAR(1),
  vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM centro_custo T1
	WHERE T1.empresa_id = vempresa 
		AND IFNULL(T1.ativo,"") = CASE IFNULL(vativo,'')
																	WHEN '' THEN IFNULL(T1.ativo,"")
																	ELSE vativo
															END;
END$$

DELIMITER ;