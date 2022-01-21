DELIMITER $$

USE `igreja`$$

DROP TRIGGER /*!50032 IF EXISTS */ `movimentacao_financeira_after_update`$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `movimentacao_financeira_after_update` AFTER UPDATE ON `movimentacao_financeira` 
    FOR EACH ROW BEGIN
    
	-- Insert record into log table
	
-- 			IF NEW.cancelado <> 'S' THEN
-- 				SET @VALOR_NEW = '';
-- 				SET @VALOR_OLD = '';
-- 				IF OLD.tipo <> NEW.tipo THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Tipo: ', NEW.tipo, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Tipo: ', OLD.tipo, '; ');
-- 				END IF;
-- 				IF OLD.`data` <> NEW.`data` THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Data: ', NEW.`data`, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Data: ', OLD.`data`, '; ');
-- 				END IF;
-- 				IF OLD.descricao <> NEW.descricao THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Descricao: ', NEW.descricao, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Descricao: ', OLD.descricao, '; ');
-- 				END IF;
-- 				IF OLD.documento <> NEW.documento THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Documento: ', NEW.documento, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Documento: ', OLD.documento, '; ');
-- 				END IF;
-- 				IF OLD.categoria_financeira_id <> NEW.categoria_financeira_id THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Conta: ', NEW.categoria_financeira_id, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Conta: ', OLD.categoria_financeira_id, '; ');
-- 				END IF;
-- 				IF OLD.valor <> NEW.valor THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Valor: ', NEW.valor, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Valor: ', OLD.valor, '; ');
-- 				END IF;
-- 				IF OLD.centro_custo_id <> NEW.centro_custo_id THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Centro Custo: ', NEW.centro_custo_id, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Centro Custo: ', OLD.centro_custo_id, '; ');
-- 				END IF;
-- 				IF OLD.contas_financeira_id <> NEW.contas_financeira_id THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Conta Bancária: ', NEW.contas_financeira_id, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Conta Bancária: ', OLD.contas_financeira_id, '; ');
-- 				END IF;
-- 				IF OLD.membro_id <> NEW.membro_id THEN
-- 					SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Contribuinte: ', NEW.membro_id, '; ');
-- 					SET @VALOR_OLD = CONCAT(@VALOR_OLD,'Contribuinte: ', OLD.membro_id, '; ');
-- 				END IF;
-- 		
-- 				INSERT INTO log_movimentacao_financeira
-- 				(movimentacao_financeira_id,
-- 				 valor_new,
-- 				 valor_old,
-- 				 mov_empresa_id,
-- 				 mov_user_id,
-- 				 mov_created,
-- 				 mov_modified,
-- 				 acao,
-- 				 empresa_id,
-- 				 user_id,
-- 				 created)
-- 				VALUES
-- 				(NEW.id,
-- 				 @VALOR_NEW,
-- 				 @VALOR_OLD,
-- 				 NEW.empresa_id,
-- 				 NEW.user_id,
-- 				 NEW.created,
-- 				 NEW.modified,
-- 				 'U',
-- 				 NEW.empresa_id,
-- 				 NEW.user_id,
-- 				 SYSDATE());
-- 			ELSE
				INSERT INTO log_movimentacao_financeira
				(movimentacao_financeira_id,
				 cancelado,
				 user_id_cancela,
				 justifica_cancela,
				 mov_empresa_id,
				 mov_user_id,
				 mov_created,
				 mov_modified,
				 acao,
				 empresa_id,
				 user_id,
				 created)
				VALUES
				(NEW.id,
				 NEW.cancelado,
				 NEW.user_id_cancela,
				 NEW.justifica_cancela,
				 NEW.empresa_id,
				 NEW.user_id,
				 NEW.created,
				 NEW.modified,
				 'D',
				 NEW.empresa_id,
				 NEW.user_id,
				 SYSDATE());
-- 			END IF;	

-- Atribuir valores para gravar na tabela movimentacao_saldo
		SELECT CONCAT(num,'-',nome) INTO @categoria
		FROM categorias_financeira
		WHERE empresa_id = OLD.empresa_id
			AND id = OLD.categoria_financeira_id;
			
		SET @saldo = 0;
		SELECT IFNULL(MS.saldo, C.saldo_inicial) INTO @saldo
		FROM contas_financeira C
		LEFT JOIN movimentacao_saldo MS
			ON C.id = MS.conta_financ_id
		WHERE C.id = OLD.contas_financeira_id
			AND C.empresa_id = OLD.empresa_id
		ORDER BY MS.created DESC
		LIMIT 1;
		
		IF OLD.tipo = 'E' THEN
			SET @conta_origem = OLD.contas_financeira_id;
			SET @conta_destino = NULL;
			SET @saldo = @saldo - OLD.valor;
			SET @descricao = CONCAT('ESTORNO na conta devido cancelamento do movimento. (Id: ',OLD.id,' - ',IFNULL(OLD.documento,''),' - ',OLD.descricao,' - ',@categoria,')');
			SET @tipo = 'S';
		ELSE	
			SET @conta_origem = NULL;
			SET @conta_destino = OLD.contas_financeira_id;
			SET @saldo = @saldo + OLD.valor;
			SET @descricao = CONCAT('CRÉDITO em conta devido cancelamento do movimento. (Id: ',OLD.id,' - ',IFNULL(OLD.documento,''),' - ',OLD.descricao,' - ',@categoria,')');
			SET @tipo = 'E';
		END IF;	
		
-- Insert record into movimentacao_saldo table
		INSERT INTO movimentacao_saldo
			(`data`
			,valor
			,tipo
			,saldo
			,conta_financ_id
			,contas_financ_origem_id
			,contas_financ_destino_id
			,descricao
			,cancelado
			,movimentacao_financeira_id
			,empresa_id
			,user_id
			,created
			,modified)
		VALUES
			(OLD.created
			,OLD.valor
			,@tipo
			,@saldo
			,OLD.contas_financeira_id
			,@conta_origem
			,@conta_destino
			,@descricao
			,'N'
			,OLD.id
			,OLD.empresa_id
			,OLD.user_id
			,OLD.created
			,OLD.created);

		END;
$$

DELIMITER ;