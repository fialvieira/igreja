DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `relacionamento_exclui`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionamento_exclui`(
				vid 				INT(11) UNSIGNED,
				vempresa_id	INT(11)
)
BEGIN
	DELETE
	FROM relacionamentos
	WHERE id = vid
		AND empresa_id = vempresa_id;
END$$

DELIMITER ;