DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_arquivo_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_arquivo_insere`(
	IN `vmovimentacao_financeira_id` INT(11) UNSIGNED,
	IN `vpath` VARCHAR(200),
	IN `vnome` VARCHAR(115),
	IN `vdataupload` DATE,
	IN `vuser_id` INT(11) UNSIGNED,
	IN `vempresa_id` INT(11) UNSIGNED,
	IN `vcreated` DATETIME
)
BEGIN
	INSERT INTO mov_fin_arquivos
	(movimentacao_financeira_id, path, nome, dataupload, user_id, empresa_id, created)
	VALUES
	(vmovimentacao_financeira_id, vpath, vnome, vdataupload, vuser_id, vempresa_id, vcreated);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;