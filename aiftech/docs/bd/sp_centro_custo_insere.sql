DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `centro_custo_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `centro_custo_insere`(
	vdescricao VARCHAR(100),
	vempresas_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME,
	vmodified DATETIME
)
BEGIN
	INSERT INTO centro_custo
	(descricao, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vdescricao, 'S', vempresas_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;