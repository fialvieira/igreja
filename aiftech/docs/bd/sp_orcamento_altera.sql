DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `orcamento_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orcamento_altera`(
	vid INT(10) UNSIGNED,
	vvalor_previsto DECIMAL(10,2),
	vempresa_id INT(11),
	vuser_id INT(11),
	vmodified DATETIME
)
BEGIN
	UPDATE orcamento
	SET
	valor_previsto = vvalor_previsto,
	user_id = vuser_id,
	modified = vmodified
	WHERE id = vid
		AND empresa_id = vempresa_id;
END$$

DELIMITER ;