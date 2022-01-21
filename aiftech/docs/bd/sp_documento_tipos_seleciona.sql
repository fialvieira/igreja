DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `documento_tipos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `documento_tipos_seleciona`(
	IN `vativo` CHAR(1),
	IN `vempresa_id` INT,
	IN `vtem_modelo` CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM documento_tipos T1
	WHERE T1.empresa_id = vempresa_id
		AND IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
									   ELSE vativo
								  END
		AND IFNULL(T1.path_modelo,"N") = CASE WHEN vtem_modelo = "S" THEN T1.path_modelo
											  WHEN vtem_modelo = "N" THEN "N"
											  ELSE IFNULL(T1.path_modelo,"N")
										 END;															
END$$

DELIMITER ;