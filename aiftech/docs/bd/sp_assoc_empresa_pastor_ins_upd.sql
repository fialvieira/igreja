DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `assoc_empresa_pastor_ins_upd`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `assoc_empresa_pastor_ins_upd`(
	IN `vempresa_id` INT(11),
	IN `vpastor_id` INT(11) UNSIGNED,
	IN `vdt_entrada` DATE,
	IN `vata_entrada` INT(11) UNSIGNED,
	IN `vdt_saida` DATE,
	IN `vata_saida` INT(11) UNSIGNED,
	IN `vcategoria` CHAR(1),
	IN `vuser_id` VARCHAR(25),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	SET @rec = 0;
	SELECT COUNT(*) INTO @rec
	FROM assoc_empresas_pastores
	WHERE empresa_id = vempresa_id
	  AND pastor_id = vpastor_id;
	 
	IF @rec = 0 THEN
		INSERT INTO assoc_empresas_pastores
		(empresa_id, pastor_id, dt_entrada, dt_saida, ata_entrada, ata_saida, categoria, user_id, created)
		VALUES
		(vempresa_id, vpastor_id, vdt_entrada, vdt_saida, vata_entrada, vata_saida, vcategoria, vuser_id, vcreated);
	ELSE
		UPDATE assoc_empresas_pastores
		SET dt_entrada = vdt_entrada,
			ata_entrada = vata_entrada,
			dt_saida = vdt_saida,
			ata_saida = vata_saida,
			categoria = vcategoria,
			user_id = vuser_id,
			modified = vmodified
		WHERE empresa_id = vempresa_id
		  AND pastor_id = vpastor_id;
	END IF;
	
END$$

DELIMITER ;