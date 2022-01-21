DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_bem_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_insere`(
	vnome VARCHAR(80),
	vdescricao TEXT,
	vempresa_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO tipo_bens
	(nome, descricao, ativo, empresa_id, user_id, created)
	VALUES
	(vnome, vdescricao, 'S', vempresa_id, vuser_id, vcreated);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;