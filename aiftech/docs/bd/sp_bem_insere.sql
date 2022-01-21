DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `bem_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `bem_insere`(
	vnome VARCHAR(200),
	videntificacao VARCHAR(100),
	vnum_serie VARCHAR(100),
	vnum_ativo VARCHAR(100),
	vmarca VARCHAR(200),
	vmodelo VARCHAR(200),
	vdescricao VARCHAR(500),
	vobservacao TEXT,
	vdata_compra DATE,
	vgarantia DATE,
	vvalor_unitario DECIMAL(18,2),
	vdepartamento_id INT(11) UNSIGNED,
	vlocal_id INT(11) UNSIGNED,
	vtipo_bem_id INT(11) UNSIGNED,
	vuser_id INT(11),
	vempresa_id INT(11),
	vcreated DATETIME,
	vmodified DATETIME
)
BEGIN
	INSERT INTO bens
	(nome, identificacao, num_serie, num_ativo, marca, modelo, descricao, observacao, data_compra, garantia, valor_unitario, departamento_id, local_id, tipo_bem_id, ativo, user_id, empresa_id, created, modified)
	VALUES
	(vnome, videntificacao, vnum_serie, vnum_ativo, vmarca, vmodelo, vdescricao, vobservacao, vdata_compra, vgarantia, vvalor_unitario, vdepartamento_id, vlocal_id, vtipo_bem_id, 'S', vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;