DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `centro_custo_set_principal`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `centro_custo_set_principal`(
	vid INT(11),
	vempresa_id INT(11),
	vprincipal CHAR(1),
	vuser_id INT(11),
	vmodified DATETIME
)
BEGIN
	SET @VALOR = 'N';
	SET @ID = '';
	
	SELECT id INTO @ID
	FROM centro_custo
	WHERE empresa_id = vempresa_id
	  AND principal = 'S';
	
	IF @id = vid THEN
		SELECT '1' ERRO, 'Obrigatório manter um centro de custo como principal.' DESC_ERRO;
	ELSE
		UPDATE centro_custo
		SET
		principal = 'N'
		WHERE id = @ID
			AND empresa_id = vempresa_id;
			
		UPDATE centro_custo
		SET
		principal = vprincipal,
		user_id = vuser_id,
		modified = vmodified
		WHERE id = vid
			AND empresa_id = vempresa_id;
			
		SELECT '0' ERRO, 'Sucesso' DESC_ERRO;
	
	END IF;
	
END$$

DELIMITER ;