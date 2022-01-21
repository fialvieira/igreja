DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_orcamentos_exclui`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_orcamentos_exclui`(
	vempresa INT(11)
 ,vcompras_id INT(11) UNSIGNED
 ,vfornecedores_id INT(11) UNSIGNED
)

BEGIN
	DELETE 
  FROM `compras_orcamentos`
	WHERE empresa_id = vempresa
		AND compras_id = vcompras_id
		AND fornecedores_id = vfornecedores_id;
END$$

DELIMITER ;