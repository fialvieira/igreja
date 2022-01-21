DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `categorias_financeira_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_insere`(
  vnum 						VARCHAR(10),
  vnome 					VARCHAR(100),
  vdescricao 			TEXT,
  vtipo 					CHAR(1),
  vcategoria_mae	INT(10) UNSIGNED,
  vempresa_id 		INT(11),
  vuser_id 				INT(11),
  vcreated 				DATETIME,
  vmodified 			DATETIME,
  vresponsavel		CHAR(2)
)
BEGIN
	INSERT INTO categorias_financeira
		(num, nome, descricao, tipo, categoria_mae, ativo, responsavel, empresa_id, user_id, created, modified)
	VALUES
		(vnum, vnome, vdescricao, vtipo, vcategoria_mae, 'S', vresponsavel, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;