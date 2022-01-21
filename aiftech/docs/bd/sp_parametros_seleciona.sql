DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `parametro_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `parametro_seleciona`(
	vempresa_id INT(11)
)
BEGIN
	SELECT P.*
	FROM parametros_sistema P
	WHERE P.empresa_id = vempresa_id;
END$$

DELIMITER ;