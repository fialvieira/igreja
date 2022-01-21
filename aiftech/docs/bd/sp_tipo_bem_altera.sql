DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `tipo_bem_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_altera`(
	vid INT(11) UNSIGNED,
	vnome VARCHAR(80),
	vdescricao TEXT,
	vativo CHAR(1),
	vempresa_id INT(11),
	vuser_id INT(11),
	vmodified DATETIME
)
BEGIN
	UPDATE tipo_bens
	SET
	nome = vnome,
	descricao = vdescricao,
	ativo = vativo,
	user_id = vuser_id,
	modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;