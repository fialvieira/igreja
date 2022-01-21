DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `solicitacao_compra_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `solicitacao_compra_altera`(
	vid INT(11) UNSIGNED,
	vsituacao CHAR(1),
	vjustificativa TEXT,
	vcategoria_financeira_id INT(10) UNSIGNED,
	vuser_id INT(11),
	vempresa_id INT(11),
	vmodified DATETIME
)
BEGIN
	UPDATE compras
	SET
		situacao = vsituacao,
		justificativa = vjustificativa,
	  categoria_financeira_id = vcategoria_financeira_id,
		user_id = vuser_id,
		modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;