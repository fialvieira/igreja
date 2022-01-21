DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `enderecos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `enderecos_seleciona`(
	vcep VARCHAR(8)
)
BEGIN
	SELECT id
	      ,cep
	      ,logradouro
	      ,bairro
	      ,localidade
	      ,estado_id uf
	      ,novo
	      ,user_id
	      ,created
	      ,modified
	FROM enderecos
	WHERE cep = vcep;
END$$

DELIMITER ;