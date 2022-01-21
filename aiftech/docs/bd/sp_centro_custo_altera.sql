DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `centro_custo_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `centro_custo_altera`(
	vid INT(11),
	vdescricao VARCHAR(40),
	vativo CHAR(1),
	vempresas_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME,
	vmodified DATETIME
)
BEGIN
	UPDATE centro_custo
	SET
	descricao = vdescricao,
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresas_id;
END$$

DELIMITER ;