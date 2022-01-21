DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `associacao_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `associacao_insere`(
	vsigla VARCHAR(10),
	vdescricao VARCHAR(250),
	vuser_id 	INT(11),
	vempresa_id 	INT(11),
	vcreated 	DATETIME
)
BEGIN
	INSERT INTO associacoes
	(sigla, descricao, ativo, user_id, empresa_id, created)
	VALUES
	(vsigla, vdescricao, 'S', vuser_id, vempresa_id, vcreated);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;