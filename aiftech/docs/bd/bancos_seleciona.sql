DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `bancos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `bancos_seleciona`()
BEGIN
	SELECT T1.*
	FROM bancos T1
	ORDER BY T1.numero;
END$$

DELIMITER ;