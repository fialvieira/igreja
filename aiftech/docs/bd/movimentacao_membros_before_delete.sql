DELIMITER $$

USE `igreja`$$

DROP TRIGGER /*!50032 IF EXISTS */ `movimentacao_membros_before_delete`$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `movimentacao_membros_before_delete` BEFORE DELETE ON `movimentacao_membros` 
    FOR EACH ROW BEGIN
		INSERT INTO log_movimentacao_membros
	(membro_id, 
	 empresa_id, 
	 `data`, 
	 ata_id, 
	 data_carta_envio, 
	 carta_id, 
	 data_carta_recebimento, 
	 carta_recebimento_path, 
	 tipo_movimentacao_membro_id, 
	 pastor_id, 
	 igreja_id, 
	 secretaria_id, 
	 pastor_pres_id,
	 observacao,
	 acao,
	 user_id,
	 created)
	VALUES
	(OLD.membro_id, 
	 OLD.empresa_id, 
	 OLD.data, 
	 OLD.ata_id, 
	 OLD.data_carta_envio, 
	 OLD.carta_id, 
	 OLD.data_carta_recebimento, 
	 OLD.carta_recebimento_path, 
	 OLD.tipo_movimentacao_membro_id, 
	 OLD.pastor_id, 
	 OLD.igreja_id, 
	 OLD.secretaria_id, 
	 OLD.pastor_pres_id,
	 OLD.observacao,
	 'D',
	 OLD.user_id,
	 SYSDATE());
    END;
$$

DELIMITER ;