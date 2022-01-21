DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `documentos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `documentos_seleciona`(
	IN `vempresa` INT(11)
)
BEGIN
	SELECT D.*, T.descricao tipo_desc
	FROM documentos D
  LEFT JOIN documento_tipos T
    ON D.tipo_documento = T.id
  WHERE D.empresa_id = vempresa
  ORDER BY D.id DESC;
END$$

DELIMITER ;