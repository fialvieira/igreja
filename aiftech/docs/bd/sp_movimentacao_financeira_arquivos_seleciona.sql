DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_arquivos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_arquivos_seleciona`(
	IN `vempresa` INT,
	IN `vmovimentacao_financeira` INT(11) UNSIGNED
)
BEGIN
	SELECT MA.*
	FROM mov_fin_arquivos MA
  WHERE MA.empresa_id = vempresa
    AND MA.movimentacao_financeira_id = vmovimentacao_financeira;
END$$

DELIMITER ;