DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `ata_tipo_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_tipo_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vdescricao` VARCHAR(150),
	IN `vtexto_padrao` TEXT,
	IN `vcartorio` CHAR(1),
	IN `vativo` CHAR(1),
	IN `vempresa_id` INT,
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE ata_tipos
	SET
	descricao = vdescricao,
	texto_padrao = vtexto_padrao,
	cartorio = vcartorio,
	ativo = vativo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;