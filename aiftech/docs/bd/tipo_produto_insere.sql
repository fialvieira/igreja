DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_produto_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_produto_insere`(
	vnome 			VARCHAR(80),
  vdescricao 	TEXT,
  vempresa_id INT(11),
  vuser_id 		INT(11),
  vcreated 		DATETIME,
  vmodified 	DATETIME
)
BEGIN
	INSERT INTO tipo_produtos
	(nome, descricao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;