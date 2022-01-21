DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_membro_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_membro_insere`(
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
	INSERT INTO movimentacao_membros
	(membro_id, 
	 empresa_id, 
	 ata_id,
	 carta_id, 
	 data_carta_recebimento, 
	 carta_recebimento_path, 
	 tipo_movimentacao_membro_id,
	 observacao,
	 user_id,
	 created,
	 modified)
	VALUES
	(vmembro_id, 
	 vempresa_id,  
	 vata_id, 
	 vcarta_id, 
	 vdata_carta_recebimento, 
	 vcarta_recebimento_path, 
	 vtipo_movimentacao_membro_id,
	 vobservacao,
	 vuser_id,
	 vcreated,
	 vmodified);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;