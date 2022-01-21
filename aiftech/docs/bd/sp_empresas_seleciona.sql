DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `empresas_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empresas_seleciona`(
	vempresa INT(11),
	vativo CHAR(1)
)
BEGIN
	SELECT T1.*, T2.logradouro, T2.bairro, T2.localidade, T3.sigla uf, T5.nome pastor, T6.sigla associacao
	FROM empresas T1
	LEFT JOIN enderecos T2
		ON T1.enderecos_id = T2.id
	LEFT JOIN estados T3
		ON T2.estado_id = T3.id
	LEFT JOIN assoc_empresas_pastores T4
		ON T1.id = T4.empresa_id
	 AND T4.categoria = 'T'	
	LEFT JOIN pastores T5
	  ON T4.pastor_id = T5.id 
	LEFT JOIN associacoes T6
	  ON t1.associacao_id = T6.id	
	WHERE T1.id = IFNULL(vempresa, T1.id)
		AND IFNULL(T1.ativo,'') = IFNULL(vativo,IFNULL(T1.ativo,''))
	ORDER BY T1.nome;
END$$

DELIMITER ;