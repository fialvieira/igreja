DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `centro_custo_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `centro_custo_seleciona`(
  vid	INT(11) UNSIGNED
)
BEGIN
	SELECT T1.*
	FROM centro_custo T1
  WHERE T1.id = vid;
END$$

DELIMITER ;