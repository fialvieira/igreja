DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `bens_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `bens_seleciona`(
	vempresa INT(11),
	vativo CHAR(1)
)
BEGIN
	SELECT T1.*
	      ,T2.nome departamento_descricao
	      ,T3.nome local_descricao
	      ,T4.nome tipobem_descricao
	FROM bens T1
	LEFT JOIN departamentos T2
		   ON T1.departamento_id = T2.id
	LEFT JOIN `local` T3
		   ON T1.local_id = T3.id
	LEFT JOIN tipo_bens T4
		   ON T1.tipo_bem_id = T4.id
	WHERE T1.empresa_id = vempresa
	  AND IFNULL(T1.ativo,'') = CASE WHEN vativo <> 'T' THEN vativo
								  ELSE IFNULL(T1.ativo,'')
							 END;
END$$

DELIMITER ;