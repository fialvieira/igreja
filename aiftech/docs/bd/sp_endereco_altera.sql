DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `endereco_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_altera`(
        IN `vid`		INT(11) UNSIGNED,
	IN `vlogradouro` 	VARCHAR(70),
	IN `vbairro` 		VARCHAR(45),
	IN `vcep` 		VARCHAR(10),
	IN `vcidade` 		VARCHAR(100),
	IN `vestado_id` 	INT(11) UNSIGNED,
	IN `vnovo`		CHAR(1),
	IN `vuser_id` 		INT(11),
	IN `vcreated` 		DATETIME,
	IN `vmodified` 		DATETIME
)
BEGIN
	UPDATE enderecos
	SET logradouro = vlogradouro,
	    bairro = vbairro,
	    cep = vcep,
	    localidade = vcidade,
	    estado_id = vestado_id,
	    novo = vnovo,
	    user_id = vuser_id,
	    created = vcreated,
	    modified = vmodified
	 WHERE id = vid;
END$$

DELIMITER ;