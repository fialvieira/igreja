DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `ata_tipo_insere`$$

CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipo_insere`(
	IN `vdescricao` VARCHAR(150),
	IN `vtexto_padrao` TEXT,
	IN `vcartorio` CHAR(1),
	IN `vempresa_id` INT,
	IN `vuser_id` INT,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO ata_tipos
	(descricao, texto_padrao, cartorio, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vdescricao, vtexto_padrao, vcartorio, 'S', vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;