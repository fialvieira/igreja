DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `cargo_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_insere`(
	vnome 		VARCHAR(45),
        vdescricao 	TEXT,
        vabreviacao 	VARCHAR(30),
        vtipo_comissao 	CHAR(1),
        vempresa_id	INT(11) UNSIGNED,
        vuser_id 	INT(11) UNSIGNED,
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	INSERT INTO cargos
	(nome, descricao, abreviacao, tipo_comissao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vabreviacao, vtipo_comissao, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;