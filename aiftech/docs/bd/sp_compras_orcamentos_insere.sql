DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_orcamentos_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_orcamentos_insere`(
	vcompras_id INT(11) UNSIGNED,
	vfornecedores_id INT(11) UNSIGNED,
	vorcamento_path VARCHAR(800),
	vnome_arquivo VARCHAR(115),
	vdata_orcamento DATE,
	vuser_id INT(11),
	vempresa_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO compras_orcamentos
	(fornecedores_id, compras_id, orcamento_path, nome_arquivo, data_orcamento, user_id, empresa_id, created)
	VALUES
	(vfornecedores_id, vcompras_id, vorcamento_path, vnome_arquivo, vdata_orcamento, vuser_id, vempresa_id, vcreated);
	
END$$

DELIMITER ;