DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `categoria_financeira_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `categoria_financeira_seleciona`(
	vid INT(11)
)
BEGIN
	SELECT T1.*, T2.nome categoria_mae_descricao
	FROM categorias_financeira T1
	LEFT JOIN categorias_financeira T2
		ON T1.categoria_mae = T2.id
	WHERE T1.id = vid
	ORDER BY T1.num;
END$$

DELIMITER ;