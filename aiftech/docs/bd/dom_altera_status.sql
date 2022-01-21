DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `dom_altera_status`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dom_altera_status`(
	vcodigo 	INT(11),
        vempresas_id 	INT(11),
        vativo 		CHAR(1),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE dons
	SET
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vcodigo
	  AND empresa_id = vempresas_id;
END$$

DELIMITER ;