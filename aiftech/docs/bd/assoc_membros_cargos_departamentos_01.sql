/*
SQLyog Community v11.33 (32 bit)
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

/*Table structure for table `assoc_membros_cargos_departamentos` */

DROP TABLE IF EXISTS `assoc_membros_cargos_departamentos`;

CREATE TABLE `assoc_membros_cargos_departamentos` (
  `membro_id` int(11) unsigned NOT NULL,
  `cargo_id` int(11) unsigned NOT NULL,
  `departamento_id` int(11) unsigned NOT NULL,
  `ativo` char(1) NOT NULL,
  `periodo` varchar(4) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`membro_id`,`cargo_id`,`departamento_id`),
  KEY `IX_cargo_id_membro_id` (`cargo_id`,`membro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela associativa entre membros e cargos';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
