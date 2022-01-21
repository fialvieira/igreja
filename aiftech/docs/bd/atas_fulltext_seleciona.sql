DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `atas_fulltext_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_fulltext_seleciona`(
	vpar 		TEXT(10000),
	vempresa_id	INT(11)
)
BEGIN
		SELECT A.*
					,T.descricao tipo_desc
		FROM atas A
		LEFT JOIN ata_tipos T
			ON A.tipo_ata = T.id
		WHERE A.ata_ft LIKE CONCAT('%', vpar, '%')
		  AND A.empresa_id = vempresa_id
		ORDER BY A.id DESC
		LIMIT 100;
END$$

DELIMITER ;