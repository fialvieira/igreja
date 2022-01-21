DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `banco_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `banco_altera`(
	vid TINYINT(4) UNSIGNED,
        vnome   VARCHAR(100),
        vnumero VARCHAR(5),
        vcnpj	VARCHAR(14)
)
BEGIN
	UPDATE bancos
	SET
	nome = vnome,
	numero = vnumero,
	cnpj = vcnpj
	WHERE id = vid;
END$$

DELIMITER ;