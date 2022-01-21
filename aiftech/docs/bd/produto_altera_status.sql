DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `produto_altera_status`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produto_altera_status`(
	vid 					INT(11) UNSIGNED,
  vempresas_id 	INT(11),
  vativo 				CHAR(1),
  vuser_id 			INT(11),
  vcreated 			DATETIME,
  vmodified 		DATETIME
)
BEGIN
	UPDATE produtos
	SET
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresas_id;
END$$

DELIMITER ;