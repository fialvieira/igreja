DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_produto_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_produto_altera`(
	vid 				INT(11) UNSIGNED,
  vnome 			VARCHAR(80),
  vdescricao 	TEXT,
  vempresa_id INT(11),
  vuser_id 		INT(11),
  vcreated 		DATETIME,
  vmodified 	DATETIME
)
BEGIN
	UPDATE tipo_produtos
	SET
	nome = vnome,
	descricao = vdescricao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;