DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `ata_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_insere`(
	IN `vdata` DATE,
	IN `vtipo_ata` INT,
	IN `vpresidencia` INT,
	IN `vtx_abertura` TEXT,
	IN `vtx_corpo` TEXT,
	IN `vtx_encerramento` TEXT,
	IN `vsecretario` INT,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME,
	IN `vata_ft` TEXT
)
BEGIN
	SET @REC = 0;
	SET @CARTORIO = 'N';
	SET @ANO_ATUAL = NULL;
	
	-- SELECT YEAR(SYSDATE()) INTO @ANO_ATUAL;
  SELECT YEAR(vdata) INTO @ANO_ATUAL;
	
	SELECT cartorio INTO @CARTORIO
	FROM ata_tipos
	WHERE id = vtipo_ata;
	
	SELECT A.num INTO @REC
	FROM atas A
	INNER JOIN ata_tipos T
		ON A.tipo_ata = T.id
	WHERE A.empresa_id = vempresa_id
		AND T.cartorio = @CARTORIO
		AND T.id = CASE WHEN @CARTORIO = 'N' THEN vtipo_ata ELSE T.id END
	ORDER BY A.id DESC
	LIMIT 1; 
	
	IF @CARTORIO = 'S' THEN
		SET @REC = @REC+1;
	ELSE
		IF SUBSTRING_INDEX(@REC,'/',-1) = @ANO_ATUAL THEN
			SET @REC = CONCAT((SUBSTRING_INDEX(@REC,'/',1)+1),'/',@ANO_ATUAL);
		ELSE
		  SET @REC = CONCAT(1,'/',@ANO_ATUAL);	
		END IF;
	END IF;
--	select @REC num;
	
	INSERT INTO atas
	(num, `data`, tipo_ata, presidencia, tx_abertura, tx_corpo, tx_encerramento, secretario, user_id, empresa_id, created, modified, ata_ft)
	VALUES
	(@REC, vdata, vtipo_ata, vpresidencia, vtx_abertura, vtx_corpo, vtx_encerramento, vsecretario, vuser_id, vempresa_id, vcreated, vmodified, vata_ft);
	SELECT LAST_INSERT_ID() id, @REC num;
END$$

DELIMITER ;