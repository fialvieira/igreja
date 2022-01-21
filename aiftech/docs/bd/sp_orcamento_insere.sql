DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `orcamento_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orcamento_insere`(
  vano CHAR(4),
	vmes CHAR(2),
	vcategoria_id INT(10) UNSIGNED,
	vvalor_previsto DECIMAL(10,2),
	vempresa_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO orcamento
		(ano, mes, categoria_id, valor_previsto, empresa_id, user_id, created)
	VALUES
		(vano, vmes, vcategoria_id, vvalor_previsto, vempresa_id, vuser_id, vcreated);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;