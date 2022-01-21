/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 5.7.21-0ubuntu0.16.04.1 : Database - igreja_hom
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

USE `igreja`;

/* Procedure structure for procedure `ata_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_altera`(
	IN `vid` INT(11) UNSIGNED,
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
	IN `vata_ft` TEXT,
	IN `vfinalizado` char(1)
)
BEGIN
	UPDATE atas
	SET	`data` = vdata,
  tipo_ata = vtipo_ata,
  presidencia = vpresidencia,
  tx_abertura = vtx_abertura,
  tx_corpo = vtx_corpo,
  tx_encerramento = vtx_encerramento,
  secretario = vsecretario,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified,
  ata_ft = vata_ft,
  finalizado = vfinalizado
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_altera`(
	vid INT(11) UNSIGNED,
        vata_id INT(11) UNSIGNED,
        vnome VARCHAR(60),
        vdataupload DATE,
        vuser_id INT(11) UNSIGNED,
        vempresa_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE ata_arquivos
	SET
	ata_id = vata_id,
	nome = vnome,
	dataupload = vdataupload,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_exclui`(
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	DELETE 
  FROM ata_arquivos
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_insere`(
	IN `vata_id` INT(11) UNSIGNED,
	IN `vpath` VARCHAR(200),
	IN `vnome` VARCHAR(115),
	IN `vdataupload` DATE,
	IN `vata_digit` CHAR(1),
	IN `vuser_id` INT(11) UNSIGNED,
	IN `vempresa_id` INT(11) UNSIGNED,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO ata_arquivos
	(ata_id, path, nome, dataupload, ata_digit, user_id, empresa_id, created, modified)
	VALUES
	(vata_id, vpath, vnome, vdataupload, vata_digit, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_seleciona`(
	IN `vempresa` INT,
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM ata_arquivos 
	WHERE empresa_id = vempresa
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivos_seleciona`(
	IN `vempresa` INT,
	IN `vata` INT(11),
	IN `vata_digit` CHAR(1)
)
BEGIN
	SELECT AA.*
	FROM ata_arquivos AA
  WHERE AA.empresa_id = vempresa
    AND AA.ata_id = vata
    AND IFNULL(AA.ata_digit,'') = CASE WHEN vata_digit = 'T' THEN IFNULL(AA.ata_digit,'')
                                       WHEN vata_digit = 'N' THEN '' 
                                       ELSE vata_digit
                                  END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_altera`(
	IN `vata_id` INT,
	IN `vid` INT,
	IN `vtitulo` VARCHAR(50),
	IN `vtexto` TEXT,
	IN `vuser_id` INT,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE ata_assuntos
	SET
	titulo = vtitulo,
  texto = vtexto,
	user_id = vuser_id,
	modified = vmodified
	WHERE ata_id = vata_id
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_exclui`(
	IN `vata_id` INT,
	IN `vid` INT
)
BEGIN
  DELETE
  FROM ata_assuntos
  WHERE ata_id = vata_id
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_insere`(
	IN `vata_id` INT,
	IN `vtitulo` VARCHAR(50),
	IN `vtexto` TEXT,
	IN `vuser_id` INT,
	IN `vempresa_id` INT,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	SET @REC = 0;
  SELECT id INTO @REC
  FROM ata_assuntos
  WHERE ata_id = vata_id 
  ORDER BY id DESC
  LIMIT 1; 
  SET @REC = @REC+1;
	INSERT INTO ata_assuntos
	(ata_id, id, titulo, texto, user_id, empresa_id, created, modified)
	VALUES
	(vata_id, @REC, vtitulo, vtexto, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT @REC id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assuntos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assuntos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assuntos_seleciona`(
	IN `vata` INT
)
BEGIN
  SELECT *
  FROM ata_assuntos
  WHERE ata_id = vata;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_insere`(
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
  SELECT num INTO @REC
  FROM atas
  WHERE empresa_id = vempresa_id
  ORDER BY num DESC
  LIMIT 1; 
  
  SET @REC = @REC+1;
  
	INSERT INTO atas
	(num, `data`, tipo_ata, presidencia, tx_abertura, tx_corpo, tx_encerramento, secretario, user_id, empresa_id, created, modified, ata_ft)
	VALUES
	(@REC, vdata, vtipo_ata, vpresidencia, vtx_abertura, vtx_corpo, vtx_encerramento, vsecretario, vuser_id, vempresa_id, vcreated, vmodified, vata_ft);
	SELECT LAST_INSERT_ID() id, @REC num;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_exclui`(
	IN `vata_id` INT(11),
	IN `vmembro_id` INT(11)
)
BEGIN
  DELETE
  FROM ata_participantes
  WHERE ata_id = vata_id
    AND membro_id = vmembro_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_insere`(
	IN `vata_id` INT(11),
	IN `vmembro_id` INT(11)
)
BEGIN
	INSERT INTO ata_participantes
	(ata_id, membro_id)
	VALUES
	(vata_id, vmembro_id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_seleciona`(
	IN `vata_id` INT(11)
,
	IN `vmembro_id` INT(11)
)
BEGIN
	SELECT AP.*, M.nome
	FROM ata_participantes AP
  LEFT JOIN membros M
    ON AP.membro_id = M.id
	WHERE AP.ata_id = vata_id
    AND AP.membro_id = vmembro_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participantes_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participantes_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participantes_seleciona`(
	IN `vata` INT
(11)
)
BEGIN
	SELECT AP.*, M.nome
	FROM ata_participantes AP
  LEFT JOIN membros M
    ON AP.membro_id = M.id
  WHERE AP.ata_id = vata;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_seleciona`(
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	SELECT A.*, T.descricao tipo_desc, M1.nome presidencia_nome, M2.nome secretario_nome
	FROM atas A
  LEFT JOIN ata_tipos T
    ON A.tipo_ata = T.id
  LEFT JOIN membros M1
    ON A.presidencia = M1.id  
  LEFT JOIN membros M2
    ON A.secretario = M2.id      
	WHERE A.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_tipo_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vdescricao` VARCHAR(50),
	IN `vtexto_padrao` TEXT,
	IN `vativo` CHAR(1),
	IN `vempresa_id` INT,
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE ata_tipos
	SET
	descricao = vdescricao,
	texto_padrao = vtexto_padrao,
	ativo = vativo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipo_insere`(
	IN `vdescricao` VARCHAR(50),
	IN `vtexto_padrao` TEXT,
	IN `vativo` CHAR(1),
	IN `vempresa_id` INT,
	IN `vuser_id` INT,
	IN `created` DATETIME,
	IN `modified` DATETIME
)
BEGIN
	INSERT INTO ata_tipos
	(descricao, texto_padrao, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vdescricao, vtexto_padrao, 'S', vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipo_seleciona`(
	IN `vid` INT
)
BEGIN
	SELECT *
	FROM ata_tipos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_tipos_seleciona`(
	IN `vativo` CHAR(1),
	IN `vempresa_id` int
)
BEGIN
	SELECT T1.*
	FROM ata_tipos T1
	WHERE empresa_id = vempresa_id
		and IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
																	 ELSE vativo
															END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `atas_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `atas_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_seleciona`(
	IN `vempresa` INT(11)
)
BEGIN
	SELECT A.*, T.descricao tipo_desc
	FROM atas A
  LEFT JOIN ata_tipos T
    ON A.tipo_ata = T.id
  WHERE A.empresa_id = vempresa
  order by A.num;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
