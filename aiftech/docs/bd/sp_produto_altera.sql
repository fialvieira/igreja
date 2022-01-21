DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `produto_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produto_altera`(
	vid 							INT(11) UNSIGNED,
  vnome 						VARCHAR(80),
  vdescricao 				TEXT,
  vunidade_medida		INT(2) UNSIGNED,
  vtipo							CHAR(1),
  vtipo_produto_id	INT(11) UNSIGNED,
  vempresa_id 			INT(11),
  vuser_id 					INT(11),
  vcreated 					DATETIME,
  vmodified 				DATETIME
)
BEGIN
	UPDATE produtos
	SET
	nome = vnome,
	descricao = vdescricao,
	unidade_medida = vunidade_medida,
	tipo = vtipo,
	tipo_produto_id = vtipo_produto_id,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;