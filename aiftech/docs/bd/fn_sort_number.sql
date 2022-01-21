DELIMITER $$

DROP FUNCTION IF EXISTS `fn_sort_number`$$

CREATE FUNCTION `igreja`.`fn_sort_number`(
			vnumber	VARCHAR(10)
    )
    RETURNS VARCHAR(100)
    BEGIN
			SET @INDICE = vnumber;
			SET @CURLENGTH = 0;
			SET @LENGTH = 0;
			SET @rtnstring = '';

			WHILE (@CURLENGTH < LENGTH(@INDICE)) DO
				SET @LENGTH = LOCATE('.', @INDICE, @CURLENGTH + 1);
				IF @LENGTH = 0 THEN
					SET @LENGTH = LENGTH(@INDICE) + 1;
				END IF;
				SET @rtnstring = CONCAT(@rtnstring, LPAD(SUBSTRING(@INDICE, @CURLENGTH + 1, @LENGTH - @CURLENGTH - 1), 4, '0'), '.');
				SET @CURLENGTH = @LENGTH;
			END WHILE;
			SET @rtnstring = SUBSTRING(@rtnstring, 1, LENGTH(@rtnstring) -1);
			RETURN @rtnstring;
    END$$
DELIMITER ;