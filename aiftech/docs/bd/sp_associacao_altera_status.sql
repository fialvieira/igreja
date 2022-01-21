DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `associacao_altera_status`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `associacao_altera_status`(
	vcodigo INT(11),
	vempresa_id INT(11),
	vativo 	CHAR(1),
	vuser_id INT(11),
	vmodified DATETIME
)
BEGIN
	UPDATE associacoes
	SET	ativo = vativo,
			user_id = vuser_id,
			modified = vmodified
	WHERE id = vcodigo
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;