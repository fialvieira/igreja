DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `categorias_financeira_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_altera`(
	vid INT(10) UNSIGNED,
	vnum VARCHAR(10),
	vnome VARCHAR(100),
	vdescricao TEXT,
	vtipo CHAR(1),
	vcategoria_mae INT(10) UNSIGNED,
	vempresa_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME,
	vmodified DATETIME
)
BEGIN
	UPDATE categorias_financeira
	SET
	num = vnum,
	nome = vnome,
	descricao = vdescricao,
	tipo = vtipo,
	categoria_mae = vcategoria_mae,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;