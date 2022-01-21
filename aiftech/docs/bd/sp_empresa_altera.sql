DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `empresa_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_altera`(
	IN `vid` INT(11),
	IN `venderecos_id` INT(11),
	IN `vativo` CHAR(1),
	IN `vcliente` CHAR(1),
	IN `vnome` VARCHAR(150),
	IN `vcnpj` VARCHAR(14),
	IN `vtelefone` VARCHAR(15),
	IN `vwhatsapp` VARCHAR(45),
	IN `vnumero` VARCHAR(5),
	IN `vcomplemento` VARCHAR(50),
	IN `vcelular` VARCHAR(45),
	IN `vabreviacao` VARCHAR(45),
	IN `vemail` VARCHAR(150),
	IN `vmatriz_id` VARCHAR(5),
	IN `vassociacao_id` INT(11),
	IN `vtipo` INT(11),
	IN `vsubdomain` VARCHAR(15)
)
BEGIN
	UPDATE empresas
	SET
		nome = vnome,
		enderecos_id = venderecos_id,
		ativo = vativo,
		cliente = vcliente,
		cnpj = vcnpj,
		telefone = vtelefone,
		whatsapp = vwhatsapp,
		numero = vnumero,
		complemento = vcomplemento,
		celular = vcelular,
		abreviacao = vabreviacao,
		email = vemail,
		matriz_id = vmatriz_id,
		associacao_id = vassociacao_id,
		tipo = vtipo,
		subdomain = vsubdomain
	WHERE id = vid;
END$$

DELIMITER ;