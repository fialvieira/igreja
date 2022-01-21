DELIMITER $$

USE `igreja`$$

DROP FUNCTION IF EXISTS `fn_diff_date`$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_diff_date`( 
	vdata_casamento DATE,
	vperiodo				CHAR(1)
) RETURNS INT(4)
BEGIN
    SET @ano_mes_data_atual = CONCAT(YEAR(CURDATE()), LPAD(MONTH(CURDATE()), 2, '0'));
    SET @ano_mes_casamento = CONCAT(YEAR(vdata_casamento), LPAD(MONTH(vdata_casamento), 2, '0'));
    IF vperiodo = 'A' THEN
			SET @diferenca = FLOOR(PERIOD_DIFF(@ano_mes_data_atual,@ano_mes_casamento) / 12);
		ELSE
			SET @diferenca = FLOOR(PERIOD_DIFF(@ano_mes_data_atual,@ano_mes_casamento));
    END IF;
    RETURN @diferenca;
END$$

DELIMITER ;