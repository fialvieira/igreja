DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `categorias_financeira_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_seleciona`(
	vempresa INT(11),
	vativo CHAR(1)
)
BEGIN
	SELECT T1.*, T2.nome categoria_mae_descricao
	FROM categorias_financeira T1
	LEFT JOIN categorias_financeira T2
				 ON T1.categoria_mae = T2.id
	WHERE T1.empresa_id = vempresa
		AND IFNULL(T1.ativo,'') = CASE IFNULL(vativo,'')
																WHEN '' THEN IFNULL(T1.ativo,'')
																ELSE vativo
		                          END
	ORDER BY T1.num, T2.num;
END$$

DELIMITER ;