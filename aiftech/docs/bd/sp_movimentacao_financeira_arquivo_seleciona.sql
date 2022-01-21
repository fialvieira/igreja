DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_arquivo_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_arquivo_seleciona`(
	IN `vempresa` INT,
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM mov_fin_arquivos 
	WHERE empresa_id = vempresa
    AND id = vid;
END$$

DELIMITER ;