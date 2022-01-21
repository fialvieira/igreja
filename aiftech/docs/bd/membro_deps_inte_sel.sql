DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membro_deps_inte_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_deps_inte_sel`(
	vid 		INT(11),
	vempresa_id	INT(11)
)
BEGIN
	SELECT d.`id`,
               d.`nome`
	FROM assoc_membros_departamentos amd
	INNER JOIN membros m
		ON amd.membro_id = m.`id`
	INNER JOIN departamentos d
		ON amd.departamento_id = d.`id`
	WHERE amd.membro_id = vid
	  AND amd.empresa_id = vempresa_id;
END$$

DELIMITER ;