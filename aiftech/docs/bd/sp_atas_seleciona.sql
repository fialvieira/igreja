DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `atas_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_seleciona`(
	IN `vempresa` INT(11),
	vlimit INT
)
BEGIN
	SELECT COUNT(*) INTO @rec FROM atas;
	
	SET vlimit = IFNULL(vlimit,@rec);
	
	SELECT A.*, T.descricao tipo_desc
	FROM atas A
  LEFT JOIN ata_tipos T
    ON A.tipo_ata = T.id
  WHERE A.empresa_id = vempresa
  ORDER BY A.id DESC
  LIMIT vlimit;
END$$

DELIMITER ;