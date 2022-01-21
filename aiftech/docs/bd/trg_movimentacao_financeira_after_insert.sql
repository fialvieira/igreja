DELIMITER $$

USE `igreja`$$

DROP TRIGGER /*!50032 IF EXISTS */ `movimentacao_financeira_after_insert`$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `movimentacao_financeira_after_insert` AFTER INSERT ON `movimentacao_financeira` 
    FOR EACH ROW BEGIN
			SET @VALOR_NEW = '';
			IF NEW.tipo IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Tipo: ', NEW.tipo, '; ');
			END IF;
			IF NEW.`data` IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Data: ', NEW.`data`, '; ');
			END IF;
			IF NEW.descricao IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Descricao: ', NEW.descricao, '; ');
			END IF;
			IF NEW.documento IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Documento: ', NEW.documento, '; ');
			END IF;
			IF NEW.categoria_financeira_id IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Conta: ', NEW.categoria_financeira_id, '; ');
			END IF;
			IF NEW.valor IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Valor: ', NEW.valor, '; ');
			END IF;
			IF NEW.centro_custo_id IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Centro Custo: ', NEW.centro_custo_id, '; ');
			END IF;
			IF NEW.contas_financeira_id IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Conta Bancária: ', NEW.contas_financeira_id, '; ');
			END IF;
			IF NEW.membro_id IS NOT NULL THEN
				SET @VALOR_NEW = CONCAT(@VALOR_NEW,'Contribuinte: ', NEW.membro_id, '; ');
			END IF;
    
	-- Insert record into log table
			INSERT INTO log_movimentacao_financeira
				(movimentacao_financeira_id,
				valor_new,
				valor_old,
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
				@VALOR_NEW,
				NULL,
				NEW.empresa_id,
				NEW.user_id,
				NEW.created,
				NEW.modified,
				'I',
				NEW.empresa_id,
				NEW.user_id,
				SYSDATE());
			
-- Atribuir valores para gravar na tabela movimentacao_saldo
			SELECT CONCAT(num,'-',nome) INTO @categoria
			FROM categorias_financeira
			WHERE empresa_id = NEW.empresa_id
				AND id = NEW.categoria_financeira_id;
				
			SET @saldo = 0;
			SELECT IFNULL(MS.saldo, C.saldo_inicial) INTO @saldo
			FROM contas_financeira C
			LEFT JOIN movimentacao_saldo MS
				ON C.id = MS.conta_financ_id
			WHERE C.id = NEW.contas_financeira_id
			  AND C.empresa_id = NEW.empresa_id
			ORDER BY MS.created DESC
			LIMIT 1;
			
			IF NEW.tipo = 'E' THEN
				SET @conta_origem = NULL;
				SET @conta_destino = NEW.contas_financeira_id;
				SET @saldo = @saldo + NEW.valor;
			ELSE	
				SET @conta_origem = NEW.contas_financeira_id;
				SET @conta_destino = NULL;
				SET @saldo = @saldo - NEW.valor;
			END IF;	
			
			SET @descricao = CONCAT(IFNULL(NEW.documento,''),' - ',NEW.descricao,' - ',@categoria);
			
	-- Insert record into log table
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
				(NEW.data
				,NEW.valor
				,NEW.tipo
				,@saldo
				,NEW.contas_financeira_id
				,@conta_origem
				,@conta_destino
				,@descricao
				,'N'
				,NEW.id
				,NEW.empresa_id
				,NEW.user_id
				,NEW.created
				,NEW.created);
    END;
$$

DELIMITER ;