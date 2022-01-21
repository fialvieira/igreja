DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `departamento_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_insere`(
	vnome 		VARCHAR(80),
        vabreviacao 	VARCHAR(255),
        veleicao	CHAR(1),
        vinteresse	CHAR(1),
        vtipo		CHAR(1),
        vempresa_id 	INT(11),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	INSERT INTO departamentos
	(nome, abreviacao, eleicao, interesse, tipo, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vabreviacao, veleicao, vinteresse, vtipo, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;