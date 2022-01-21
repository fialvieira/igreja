DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `produto_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produto_insere`(
	vnome 						VARCHAR(80),
  vdescricao 				TEXT,
  vunidade_medida		INT(2) UNSIGNED,
  vtipo							CHAR(1),
  vtipo_produto_id	INT(11) UNSIGNED,
  vfornecedor_id		INT(11) UNSIGNED,
  vempresa_id 			INT(11),
  vuser_id 					INT(11),
  vcreated 					DATETIME,
  vmodified 				DATETIME
)
BEGIN
	INSERT INTO produtos
	(nome, descricao, unidade_medida, tipo, tipo_produto_id, fornecedor_id, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vunidade_medida, vtipo, vtipo_produto_id, vfornecedor_id, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;