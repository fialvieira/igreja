DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_bem_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_seleciona`(
	vid INT(11) UNSIGNED,
	vempresa INT(11)
)
BEGIN
	SELECT *
	FROM tipo_bens 
	WHERE id = vid
	  AND empresa_id = vempresa;
END$$

DELIMITER ;