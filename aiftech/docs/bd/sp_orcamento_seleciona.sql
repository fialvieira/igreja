DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `orcamento_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orcamento_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT T1.*, T2.nome categoria_nome
	FROM orcamento T1
	LEFT JOIN categorias_financeira T2
				 ON T1.categoria_id = T2.id
	WHERE T1.id = vid; 
END$$

DELIMITER ;