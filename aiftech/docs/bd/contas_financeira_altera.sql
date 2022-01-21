DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `contas_financeira_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_altera`(
	vid INT(10) UNSIGNED,
        vnome VARCHAR(100),
        vdescricao TEXT,
        vbanco_id TINYINT(4) UNSIGNED,
        vagencia VARCHAR(10),
        vnumero VARCHAR(10),
        vvariacao VARCHAR(5),
        vtipo_conta CHAR(1),
        vtipo_aplicacao CHAR(1),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME,
        vsaldo_inicial DECIMAL(10,2)
)
BEGIN
	UPDATE contas_financeira
	SET
	nome = vnome,
	descricao = vdescricao,
	banco_id = vbanco_id,
	agencia = vagencia,
	numero = vnumero,
	variacao = vvariacao,
	tipo_conta = vtipo_conta,
	tipo_aplicacao = vtipo_aplicacao,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified,
	saldo_inicial = vsaldo_inicial
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;