DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `bem_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `bem_altera`(
	vid INT(11) UNSIGNED,
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
	vativo CHAR(1),
	vuser_id INT(11),
	vempresa_id INT(11),
	vcreated DATETIME,
	vmodified DATETIME
)
BEGIN
	UPDATE bens
	SET
	nome = vnome,
	identificacao = videntificacao,
	num_serie = vnum_serie,
	num_ativo = vnum_ativo,
	marca = vmarca,
	modelo = vmodelo,
	descricao = vdescricao,
	observacao = vobservacao,
	data_compra = vdata_compra,
	garantia = vgarantia,
	valor_unitario = vvalor_unitario,
	departamento_id = vdepartamento_id,
	local_id = vlocal_id,
	tipo_bem_id = vtipo_bem_id,
	ativo = vativo,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;