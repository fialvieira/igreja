DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `associacao_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `associacao_altera`(
	vid INT(11),
	vsigla VARCHAR(10),
	vdescricao VARCHAR(250),
	vuser_id 	INT(11),
	vempresa_id	INT(11),
	vmodified 	DATETIME
)
BEGIN
	UPDATE associacoes
	SET	sigla = vsigla,
			descricao = vdescricao,
			user_id = vuser_id,
			modified = vmodified
	WHERE id = vid
	AND empresa_id = vempresa_id;
END$$

DELIMITER ;