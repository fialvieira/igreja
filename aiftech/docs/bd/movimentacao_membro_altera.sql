DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_membro_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_membro_altera`(
				vid 													INT(11) UNSIGNED,
				vmembro_id 	  								INT(11) UNSIGNED,
        vempresa_id 									INT(11),
        vata_id												INT(11) UNSIGNED,
        vcarta_id 										INT(11) UNSIGNED,
        vdata_carta_recebimento 			DATE,
        vcarta_recebimento_path				VARCHAR(1000),
        vtipo_movimentacao_membro_id	INT(11) UNSIGNED,
        vobservacao										TEXT,
        vuser_id											INT(11),
        vcreated											DATETIME,
        vmodified											DATETIME
)
BEGIN
	UPDATE movimentacao_membros
	SET
	membro_id = vmembro_id, 
	ata_id = vata_id, 
	carta_id = vcarta_id, 
	data_carta_recebimento = vdata_carta_recebimento, 
	carta_recebimento_path = vcarta_recebimento_path, 
	tipo_movimentacao_membro_id = vtipo_movimentacao_membro_id,
	observacao = vobservacao,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid
		AND empresa_id = vempresa_id;
END$$

DELIMITER ;