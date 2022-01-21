DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `departamento_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_altera`(
	vid 		INT(11) UNSIGNED,
        vnome 		VARCHAR(255),
        vabreviacao 	VARCHAR(255),
        veleicao	CHAR(1),
        vinteresse	CHAR(1),
        vtipo		CHAR(1),
        vempresa_id	INT(11),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE departamentos
	SET
	nome = vnome,
	abreviacao = vabreviacao,
	eleicao = veleicao,
	interesse = vinteresse,
	tipo = vtipo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;