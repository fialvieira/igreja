DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `associacao_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `associacao_seleciona`(
	vid INT(11) 
)
BEGIN
	SELECT *
	FROM associacoes 
	WHERE id = vid;
END$$

DELIMITER ;