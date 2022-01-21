DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `parametro_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `parametro_altera`(
	vid INT(11) UNSIGNED,
	vidade_quorum INT(3),
	vid_presidentes_ata VARCHAR(50),
	vid_secretarios_ata VARCHAR(50),
	vemail_administrativo VARCHAR(200),
	vemail_pastor VARCHAR(200),
	vuser_id INT(11),
	vmodified DATETIME
)
BEGIN
	UPDATE parametros_sistema
	SET idade_quorum = vidade_quorum
	   ,id_presidentes_ata = vid_presidentes_ata
	   ,id_secretarios_ata = id_secretarios_ata
	   ,email_administrativo = vemail_administrativo
	   ,email_pastor = vemail_pastor
	   ,user_id = vuser_id
	   ,modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;