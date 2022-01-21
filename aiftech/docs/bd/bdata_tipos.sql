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

/*Table structure for table `ata_tipos` */

DROP TABLE IF EXISTS `ata_tipos`;

CREATE TABLE `ata_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `ativo` char(1) NOT NULL,
  `texto_padrao` text,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Tipos de Ata';

/*Data for the table `ata_tipos` */

insert  into `ata_tipos`(`id`,`descricao`,`ativo`,`texto_padrao`,`empresa_id`,`user_id`,`created`,`modified`) values (1,'Reunião do Conselho Diretor','S','Presidida pelo irmão #PRESIDENTE, presidente em exercício, com início às hh:mm Com a presença de 00 membros: ',1,7,'2017-11-29 17:33:49','2018-02-15 13:45:31'),(2,'Assembleia Geral Extraordinária','S',NULL,1,1,'2017-11-29 17:40:40','2017-11-29 17:40:41'),(3,'Assembleia Geral Ordinária','S',NULL,1,1,'2017-11-29 17:41:23','2017-11-29 17:41:30'),(4,'Assembleia Solene','S',NULL,1,1,'2017-11-29 17:41:56',NULL);

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
