DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_altera`(
	vid INT(11) UNSIGNED,
	vtipo CHAR(1),
	vdata DATE,
	vdescricao VARCHAR(250),
	vdocumento VARCHAR(20),
	vcategoria_financeira INT(10) UNSIGNED,
	vvalor DECIMAL(10,2),
	vcentro_custo INT(11) UNSIGNED,
	vmembro INT(11) UNSIGNED,
	vcancelado CHAR(1),
	vuser_cancela INT(11),
	vjustifica_cancela TEXT,
	vempresa_id INT(11),
	vuser_id INT(11),
	vmodified DATETIME,
	vcontas_financeira_id INT UNSIGNED,
	vcompras_id INT(11) UNSIGNED
)
BEGIN
	UPDATE movimentacao_financeira
	SET
	tipo = vtipo,
	`data` = vdata,
	descricao = vdescricao,
	documento = vdocumento,
	categoria_financeira_id = vcategoria_financeira,
	valor = vvalor,
	centro_custo_id = vcentro_custo,
	membro_id = vmembro,
	cancelado = vcancelado,
	user_id_cancela = vuser_cancela,
	justifica_cancela = vjustifica_cancela,
	user_id = vuser_id,
	modified = vmodified,
	contas_financeira_id = vcontas_financeira_id,
	compras_id = IFNULL(vcompras_id, compras_id)
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;