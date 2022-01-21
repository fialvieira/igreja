DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_saldo_insere`$$

CREATE DEFINER=`root`@`%` PROCEDURE `movimentacao_saldo_insere`(
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
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    GET DIAGNOSTICS CONDITION 1 @errno = MYSQL_ERRNO;
    SELECT @errno AS ERRO;
  ROLLBACK;
	END;

	START TRANSACTION;
	-- INSERINDO MOVIMENTO DA CONTA DE ORIGEM
	INSERT INTO `igreja`.`movimentacao_saldo`
	(
  `data`,
  `valor`,
  `tipo`,
  `saldo`,
  `conta_financ_id`,
  `contas_financ_origem_id`,
  `contas_financ_destino_id`,
  `descricao`,
  `cancelado`,
  `empresa_id`,
  `user_id`,
  `created`,
  `modified`
	) 
	VALUES
  (
    vdata,
    vvalor,
    'S',
    vsaldo_origem,
    vconta_financ_origem_id,
    vconta_financ_origem_id,
    vconta_financ_destino_id,
    vdescricao,
    'N',
    vempresa_id,
    vuser_id,
    vcreated,
    vmodified
  );

	INSERT INTO `igreja`.`movimentacao_saldo`
	(
  `data`,
  `valor`,
  `tipo`,
  `saldo`,
  `conta_financ_id`,
  `contas_financ_origem_id`,
  `contas_financ_destino_id`,
  `descricao`,
  `cancelado`,
  `empresa_id`,
  `user_id`,
  `created`,
  `modified`
	) 
	VALUES
  (
    vdata,
    vvalor,
    'E',
    vsaldo_destino,
    vconta_financ_destino_id,
    vconta_financ_origem_id,
    vconta_financ_destino_id,
    vdescricao,
    'N',
    vempresa_id,
    vuser_id,
    vcreated,
    vmodified
  );
	COMMIT;
END$$
DELIMITER ;