DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membros_quorum_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_quorum_seleciona`(
	IN `vquorum` CHAR(1),
	IN `vempresa` INT(11)
)
BEGIN
	SELECT m.*, c.nome cargo_nome
	FROM membros m
	INNER JOIN membros_frequencia mf
		ON m.frequencia_id = mf.id
	LEFT JOIN assoc_membros_cargos mc
	       ON m.id = mc.membro_id
	LEFT JOIN cargos c
	      ON mc.cargo_id = c.id  
	WHERE mf.quorum = IFNULL(vquorum, mf.quorum)
	  AND m.empresa_id = vempresa;
	
END$$

DELIMITER ;