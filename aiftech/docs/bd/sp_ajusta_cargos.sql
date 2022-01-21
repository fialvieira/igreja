DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `ajusta_cargos`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ajusta_cargos`(
        IN empresa_id INT(11),
        IN ativo_de   CHAR(1),
        IN ativo_para CHAR(1),
        IN cargo_id   INT(11) UNSIGNED      
    )
BEGIN

        DECLARE EXIT HANDLER FOR SQLEXCEPTION 
        BEGIN
            SET @erro = 1;
            SET @msg = CONCAT('ERRO AO ATUALIZAR CARGOS: ', cargo_id);
            ROLLBACK;
        END;
        START TRANSACTION;
        
        INSERT INTO assoc_membros_cargos_departamentos (membro_id, cargo_id, departamento_id, ativo, periodo, empresa_id, user_id, created, modified)
        SELECT MCD.membro_id, MCD.cargo_id, MCD.departamento_id, ativo_de, YEAR(CURDATE()), MCD.empresa_id, MCD.user_id, CURDATE(), NOW()
        FROM assoc_membros_cargos_departamentos MCD
        WHERE MCD.`empresa_id` = empresa_id
          AND MCD.`ativo` = ativo_de
          AND MCD.`cargo_id` = cargo_id
          AND MCD.periodo < YEAR(CURDATE());
          
        UPDATE assoc_membros_cargos_departamentos MCD
        SET MCD.ativo = ativo_para
        WHERE MCD.`empresa_id` = empresa_id
          AND MCD.`ativo` = ativo_de
          AND MCD.`cargo_id` = cargo_id
          AND MCD.periodo < YEAR(CURDATE());
          
        SET @erro = 0;
        SET @msg = CONCAT('SUCESSO AO ATUALIZAR CARGOS: ', cargo_id);
                  
        COMMIT;
        
        INSERT INTO log_procs (proc, erro, mensagem, empresa_id, `data`)
        SELECT 'ajusta_cargos',  @erro, @msg, empresa_id, NOW();
        
	END$$

DELIMITER ;