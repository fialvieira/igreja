DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `contas_financeira_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_insere`(
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
	INSERT INTO contas_financeira
	(nome, descricao, banco_id, agencia, numero, variacao, tipo_conta, tipo_aplicacao, empresa_id, user_id, created, modified, saldo_inicial)
	VALUES
	(vnome, vdescricao, vbanco_id, vagencia, vnumero, vvariacao, vtipo_conta, vtipo_aplicacao, vempresa_id, vuser_id, vcreated, vmodified, vsaldo_inicial);
	SELECT LAST_INSERT_ID() id;
END$$

DELIMITER ;