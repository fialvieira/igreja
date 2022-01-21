DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `endereco_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_insere`(
	IN `vlogradouro` 	VARCHAR(70),
	IN `vbairro` 			VARCHAR(45),
	IN `vcep` 				VARCHAR(10),
	IN `vcidade` 			VARCHAR(100),
	IN `vestado_id` 	INT(11) UNSIGNED,
	IN `vnovo`				CHAR(1),
	IN `vuser_id` 		INT(11),
	IN `vcreated` 		DATETIME,
	IN `vmodified` 		DATETIME
)
BEGIN
	INSERT INTO enderecos
	(logradouro, bairro, cep, localidade, estado_id, novo, user_id, created, modified)
	VALUES
	(vlogradouro, vbairro, vcep, vcidade, vestado_id, vnovo, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;