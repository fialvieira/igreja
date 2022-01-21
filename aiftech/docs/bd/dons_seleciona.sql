DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `dons_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dons_seleciona`(
	vempresa INT(11),
	vativo	 CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM dons T1
        WHERE T1.empresa_id = vempresa
          AND IFNULL(T1.ativo, '') = CASE IFNULL(vativo, '')
					WHEN '' THEN T1.ativo
					ELSE vativo
				     END
        ORDER BY T1.nome;
END$$

DELIMITER ;