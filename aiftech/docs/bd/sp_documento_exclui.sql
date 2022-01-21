DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `documento_exclui`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `documento_exclui`(
	vid INT(11) UNSIGNED,
  vempresa_id INT
)
BEGIN
	DELETE 
	FROM documentos
	WHERE id = vid
	  AND empresa_id = vempresa_id;
	  
END$$

DELIMITER ;