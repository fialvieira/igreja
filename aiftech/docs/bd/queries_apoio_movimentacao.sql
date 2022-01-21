/*
	IN `vdata` 										DATE,
	IN `vdescricao` 							VARCHAR(250),
	IN `vconta_financ_origem_id` 	INT(10) UNSIGNED,
	IN `vconta_financ_destino_id` INT(10) UNSIGNED,
	IN `vvalor` 									DECIMAL(10,2),
	IN `vsaldo_origem` 						DECIMAL(10,2),
	IN `vsaldo_destino`						DECIMAL(10,2),
	IN `vuser_id` 								INT,
	IN `vempresa_id` 							INT,
	IN `vcreated` 								DATETIME,
	IN `vmodified` 								DATETIME
*/

CALL movimentacao_saldo_insere('2018-07-12', 'XPTO', 1, 2, 100.00, 9956.89, 100.00, 1, 1, CURDATE(), CURDATE());

CALL movimentacao_saldo_sel(1, NULL, 'N', '2018-07-01', '2018-07-12');

CALL movimentacao_financeira_sel(1, NULL, NULL, )



SELECT id, saldo
FROM movimentacao_saldo
WHERE conta_financ_id = 2
	AND empresa_id = 1
	ORDER BY created DESC
	LIMIT 1
	
SELECT id, saldo_inicial saldo
FROM contas_financeira
WHERE id = 1
	AND empresa_id = 1
                                      
ALTER TABLE `igreja`.`contas_financeira`   
  CHANGE `saldo_inicial` `saldo_inicial` DECIMAL(10,2) DEFAULT 0.00  NULL;
