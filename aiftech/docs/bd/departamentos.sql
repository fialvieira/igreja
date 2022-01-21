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

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `abreviacao` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `eleicao` char(1) DEFAULT NULL,
  `interesse` char(1) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL COMMENT 'M,D',
  `ativo` char(1) DEFAULT 'S' COMMENT 'S,N',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Departamentos*Cadastro Departamentos';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
