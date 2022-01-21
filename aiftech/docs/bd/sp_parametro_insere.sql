DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `parametro_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `parametro_insere`(
	vempresa_id INT(11),
	vidade_quorum INT(3),
	vid_presidentes_ata VARCHAR(50),
	vid_secretarios_ata VARCHAR(50),
	vemail_administrativo VARCHAR(200),
	vemail_pastor VARCHAR(200),
	vuser_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO parametros_sistema
	(empresa_id, idade_quorum, id_presidentes_ata, id_secretarios_ata, email_administrativo, email_pastor, user_id, created)
	VALUES
	(vempresa_id, vidade_quorum, vid_presidentes_ata, vid_secretarios_ata, vemail_administrativo, vemail_pastor, vuser_id, vcreated);
	
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;