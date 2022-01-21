DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_financeira_arquivo_exclui`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_financeira_arquivo_exclui`(
	IN `vempresa` INT(11),
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	DELETE 
  FROM mov_fin_arquivos
	WHERE empresa_id = vempresa
	  AND id = vid;
END$$

DELIMITER ;