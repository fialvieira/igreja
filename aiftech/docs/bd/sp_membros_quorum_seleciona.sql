DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membros_quorum_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_quorum_seleciona`(
	IN `vquorum` CHAR(1),
	IN `vempresa` INT(11)
)
BEGIN
    SELECT m.*, c.nome cargo_nome, d.nome dep_nome
    FROM membros m
    INNER JOIN membros_frequencia mf
        ON m.frequencia_id = mf.id
    LEFT JOIN assoc_membros_cargos_departamentos mcd
        ON m.id = mcd.membro_id
       AND mcd.ativo = 'S'
    LEFT JOIN cargos c
        ON mcd.cargo_id = c.id  
    LEFT JOIN departamentos d
				ON mcd.departamento_id = d.id
    WHERE mf.quorum = IFNULL(vquorum, mf.quorum)
      AND m.empresa_id = vempresa
    ORDER BY m.nome;
END$$

DELIMITER ;