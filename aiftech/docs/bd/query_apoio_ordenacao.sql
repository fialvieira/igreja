DELIMITER $$
DROP PROCEDURE IF EXISTS `teste`$$
CREATE PROCEDURE `teste`()
BEGIN

	SET @INDICE = '1.10.1';
	SET @CURLENGTH = 0;
	SET @LENGTH = 0;
	SET @rtnstring = '';

	WHILE (@CURLENGTH < LENGTH(@INDICE)) DO
		SET @LENGTH = LOCATE('.', @INDICE, @CURLENGTH + 1);
		IF @LENGTH = 0 THEN
			SET @LENGTH = LENGTH(@INDICE) + 1;
		END IF;
		/*set @rtnstring = @rtnstring + right('0000' + substring(@indexnum, @curlength + 1, @length - @curlength - 1), 4) + '.'*/
		SET @rtnstring = CONCAT(@rtnstring, LPAD(SUBSTRING(@INDICE, @CURLENGTH + 1, @LENGTH - @CURLENGTH - 1), 4, '0'), '.');
		SET @CURLENGTH = @LENGTH;
	END WHILE;
	SET @rtnstring = SUBSTRING(@rtnstring, 1, LENGTH(@rtnstring) -1);
	SELECT @rtnstring;

END $$


CALL teste();