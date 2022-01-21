DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `documentos_fulltext_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `documentos_fulltext_seleciona`(
	vpar 		TEXT(10000),
	vempresa_id	INT(11)
)
BEGIN
		SELECT D.*
					,T.descricao tipo_desc
		FROM documentos D
		LEFT JOIN documento_tipos T
			ON D.tipo_documento = T.id
		WHERE D.documento_ft LIKE CONCAT('%', vpar, '%')
		  AND D.empresa_id = vempresa_id
		ORDER BY D.id DESC;
END$$

DELIMITER ;