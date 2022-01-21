DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `banco_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `banco_insere`(
  vnome   VARCHAR(100),
  vnumero VARCHAR(5),
  vcnpj	  VARCHAR(14)
)
BEGIN
	INSERT INTO bancos
	(nome, numero, cnpj)
	VALUES
	(vnome, vnumero, vcnpj);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;