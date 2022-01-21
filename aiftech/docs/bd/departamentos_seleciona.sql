DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `departamentos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `departamentos_seleciona`(
	vempresa 	INT(11),
	vativo	 	CHAR(1),
	veleicao 	CHAR(1),
	vinteresse	CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM departamentos T1
        WHERE T1.empresa_id = vempresa
	  AND IFNULL(T1.ativo, '') = CASE IFNULL(vativo, '')
					WHEN '' THEN T1.ativo
					ELSE vativo
				     END
	  AND IFNULL(T1.eleicao, '') = CASE IFNULL(veleicao, '')
					  WHEN '' THEN T1.eleicao
					  ELSE veleicao
				       END
	  AND IFNULL(T1.interesse, '') = CASE IFNULL(vinteresse, '')
					    WHEN '' THEN T1.interesse
					    ELSE vinteresse
					 END
	ORDER BY T1.nome;
END$$

DELIMITER ;