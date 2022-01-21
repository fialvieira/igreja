DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `categoria_financeira_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `categoria_financeira_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT T1.*
	FROM categorias_financeira T1
	WHERE T1.id = vid; 
END$$

DELIMITER ;