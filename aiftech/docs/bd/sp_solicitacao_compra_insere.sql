DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `solicitacao_compra_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `solicitacao_compra_insere`(
	vdata DATE,
	vsituacao CHAR(1),
	vjustificativa TEXT,
	vcategoria_financeira_id INT(10) UNSIGNED,
	vsolicitante_id INT(11) UNSIGNED,
	vuser_id INT(11),
	vempresa_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO compras
	(data_solicitacao, situacao, justificativa, categoria_financeira_id, solicitante_id, user_id, empresa_id, created)
	VALUES
	(vdata, vsituacao, vjustificativa, vcategoria_financeira_id, vsolicitante_id, vuser_id, vempresa_id, vcreated);
	
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;