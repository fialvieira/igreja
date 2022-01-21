DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_situacao_upd`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_situacao_upd`(
				vid							INT(11) UNSIGNED,
				vempresa_id  		INT(11),
				vautorizador 		INT(11) UNSIGNED,
				vdt_autorizacao DATETIME,
				vobservacao			TEXT,
				vsituacao 	 		CHAR(1),
				vuser_id 				INT(11),
				vmodified				DATETIME
    )
BEGIN
    
			UPDATE compras
			SET situacao = vsituacao
				 ,autorizador_id = vautorizador
				 ,data_autorizacao = vdt_autorizacao
				 ,observacao = vobservacao
				 ,user_id = vuser_id
				 ,modified = vmodified
			WHERE `id` = vid
				AND `empresa_id` = vempresa_id;
				
    END$$

DELIMITER ;