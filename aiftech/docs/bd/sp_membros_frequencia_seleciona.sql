DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membros_frequencia_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_frequencia_seleciona`(
	vid 	INT(11) UNSIGNED,
	vemp_id	INT(11)
)
BEGIN
	IF vid IS NULL THEN
		SELECT mf.*
		FROM membros_frequencia mf
		WHERE mf.empresa_id = vemp_id
		  AND mf.ativo = 'S'
		ORDER BY STATUS;
	ELSE
		SELECT mf.*
		FROM membros_frequencia mf
		WHERE mf.id = vid
		  AND mf.empresa_id = vemp_id
		  AND mf.ativo = 'S'
		ORDER BY STATUS;
	END IF;
END$$

DELIMITER ;