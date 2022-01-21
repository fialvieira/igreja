DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `orcamento_seleciona_todos`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orcamento_seleciona_todos`(
	vempresa INT(11),
	vano CHAR(4),
	vmes CHAR(2)
)
BEGIN
	SELECT T1.*, T2.nome categoria_descricao
	FROM orcamento T1
	LEFT JOIN categorias_financeira T2
				 ON T1.categoria_id = T2.id
	WHERE T1.empresa_id = vempresa
		AND IFNULL(T1.ano,'') = CASE IFNULL(vano,'')
																WHEN '' THEN IFNULL(T1.ano,'')
																ELSE vano
														END
		AND IFNULL(T1.mes,'') = CASE IFNULL(vmes,'')
																WHEN '' THEN IFNULL(T1.mes,'')
																ELSE vmes
														END
	ORDER BY T1.ano DESC, CAST(T1.mes AS UNSIGNED);
														
END$$

DELIMITER ;