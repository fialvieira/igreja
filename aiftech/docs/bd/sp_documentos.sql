/*
SQLyog Community v12.09 (64 bit)
MySQL - 5.7.14 : Database - igreja
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`igreja` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `igreja`;

/* Procedure structure for procedure `documento_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `documento_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `documento_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vdata` DATE,
	IN `vhora` time,
	IN `vtipo_documento` INT,
	IN `vpresidencia` INT,
	IN `vmembros` TEXT,
	IN `vigreja_destino_id` INT,
	IN `vpastor_destino_id` INT(10) UNSIGNED,
	IN `vsecretario` INT,
	IN `vdocumento_ft` TEXT,
	IN `vfinalizado` char(1),
	IN `vpath_arquivo` varCHAR(200),
	IN `vextensao` CHAR(1),
	IN `vata_id` INT(11) unsigned,
	IN `vdata_carta` DATE,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE documentos
	SET	`data` = vdata,
	hora = vhora,
  tipo_documento = vtipo_documento,
  presidencia = vpresidencia,
  membros = vmembros,
  igreja_destino_id = vigreja_destino_id,
  pastor_destino_id = vpastor_destino_id,
  secretario = vsecretario,
  finalizado = vfinalizado,
  documento_ft = vdocumento_ft,
  path_arquivo = vpath_arquivo,
  extensao = vextensao,
  ata_id = vata_id,
	data_carta = vdata_carta,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `documento_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `documento_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `documento_insere`(
	IN `vdata` DATE,
	IN `vhora` time,
	IN `vtipo_documento` INT,
	IN `vpresidencia` INT,
	IN `vmembros` TEXT,
	IN `vigreja_destino_id` INT,
	IN `vpastor_destino_id` INT(10) unsigned,
	IN `vsecretario` INT,
	IN `vdocumento_ft` TEXT,
	IN `vpath_arquivo` varchar(200),
	IN `vextensao` char(1),
	IN `vata_id` INT(11) unsigned,
	IN `vdata_carta` DATE,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	SET @REC = 0;
	SET @ANO_ATUAL = NULL;
	
	SELECT YEAR(SYSDATE()) INTO @ANO_ATUAL;
	
	SELECT D.num INTO @REC
	FROM documentos D
	WHERE D.empresa_id = vempresa_id
	ORDER BY D.id DESC
	LIMIT 1; 
	
	IF SUBSTRING_INDEX(@REC,'/',-1) = @ANO_ATUAL THEN
		SET @REC = CONCAT((SUBSTRING_INDEX(@REC,'/',1)+1),'/',@ANO_ATUAL);
	ELSE
		SET @REC = CONCAT(1,'/',@ANO_ATUAL);	
	END IF;
--	select @REC num;
	
	INSERT INTO documentos
	(num, `data`, hora, tipo_documento, presidencia, membros, igreja_destino_id, pastor_destino_id, secretario, documento_ft, path_arquivo, extensao, ata_id, data_carta, user_id, empresa_id, created, modified)
	VALUES
	(@REC, vdata, vhora, vtipo_documento, vpresidencia, vmembros, vigreja_destino_id, vpastor_destino_id, vsecretario, vdocumento_ft, vpath_arquivo, vextensao, vata_id, vdata_carta, vuser_id, vempresa_id, vcreated, vmodified);
	
	SELECT LAST_INSERT_ID() id, @REC num;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
