DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `empresa_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_insere`(
	IN `venderecos_id` INT(11),
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
	INSERT INTO empresas
	(enderecos_id, ativo, cliente, nome, cnpj, telefone, whatsapp, numero, complemento, celular, abreviacao, email, matriz_id, associacao_id, tipo, subdomain)
	VALUES
	(venderecos_id, 'S', vcliente, vnome, vcnpj, vtelefone, vwhatsapp, vnumero, vcomplemento, vcelular, vabreviacao, vemail, vmatriz_id, vassociacao_id, vtipo, vsubdomain);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;