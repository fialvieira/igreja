DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_bens_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bens_seleciona`(
	vempresa INT(11),
	vativo CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM tipo_bens T1
	WHERE empresa_id = vempresa
	  AND IFNULL(ativo,'') = CASE WHEN vativo <> 'T' THEN vativo 
	                              ELSE IFNULL(ativo,'')
	                         END;
END$$

DELIMITER ;