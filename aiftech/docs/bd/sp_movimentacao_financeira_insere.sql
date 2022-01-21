DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_insere`(
	vtipo CHAR(1),
	vdata DATE,
	vdescricao VARCHAR(250),
	vdocumento VARCHAR(20),
	vcategoria_financeira INT(10) UNSIGNED,
	vvalor DECIMAL(10,2),
	vcentro_custo INT(11) UNSIGNED,
	vmembro INT(11) UNSIGNED,
	vempresa_id INT(11),
	vuser_id INT(11),
	vcreated DATETIME,
	vcontas_financeira_id INT UNSIGNED,
	vcompras_id INT(11) UNSIGNED
)
BEGIN
	INSERT INTO movimentacao_financeira
		(tipo, `data`, descricao, documento, categoria_financeira_id, valor, centro_custo_id, membro_id, cancelado, empresa_id, user_id, created, contas_financeira_id, compras_id)
	VALUES
		(vtipo, vdata, vdescricao, vdocumento, vcategoria_financeira, vvalor, vcentro_custo, vmembro, 'N', vempresa_id, vuser_id, vcreated, vcontas_financeira_id, vcompras_id);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;