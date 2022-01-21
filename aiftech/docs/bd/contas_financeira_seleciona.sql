DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `contas_financeira_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
				,T2.nome banco_descricao
				,CASE IFNULL(T1.tipo_conta, '')
						WHEN '' THEN ''
						WHEN 'C' THEN 'Corrente'
						WHEN 'A' THEN 'Aplicação'
				 END tipo_conta_descricao
				,CASE IFNULL(T1.tipo_aplicacao, '')
						WHEN '' THEN ''
						WHEN 'P' THEN 'Própria'
						WHEN 'T' THEN 'Transitória'
				 END tipo_aplicacao_descricao
	FROM contas_financeira T1
	LEFT JOIN bancos T2
		ON T1.banco_id = T2.id
  WHERE T1.empresa_id = vempresa;
END$$

DELIMITER ;