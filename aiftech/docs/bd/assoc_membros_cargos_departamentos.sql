/*
SQLyog Ultimate v12.4.1 (64 bit)
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
  `periodo` varchar(4) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`membro_id`,`cargo_id`,`departamento_id`,`periodo`),
  KEY `IX_cargo_id_membro_id` (`cargo_id`,`membro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela associativa entre membros e cargos';

/*Data for the table `assoc_membros_cargos_departamentos` */

insert  into `assoc_membros_cargos_departamentos`(`membro_id`,`cargo_id`,`departamento_id`,`ativo`,`periodo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(3879,1,10,'S','2018',1,7,'2018-01-20 14:20:00','2018-01-27 16:11:33'),
(3994,4,6,'N','2017',1,7,'2018-01-20 14:20:00','2018-01-27 16:06:47'),
(3994,4,6,'S','2018',1,7,'2018-01-20 14:20:00','2018-01-27 16:06:47'),
(3995,56,20,'S','2018',1,7,'2018-01-27 16:14:17','2018-01-27 16:14:20');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
