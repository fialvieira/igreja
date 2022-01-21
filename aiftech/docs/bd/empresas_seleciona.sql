DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `empresas_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empresas_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM empresas T1
        WHERE T1.id = IFNULL(vempresa, T1.id)
        ORDER BY T1.nome;
END$$

DELIMITER ;