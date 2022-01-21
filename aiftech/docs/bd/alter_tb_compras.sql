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

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `situacao` char(1) NOT NULL,
  `solicitante_id` int(11) unsigned NOT NULL,
  `data_solicitacao` datetime NOT NULL,
  `justificativa` text NOT NULL,
  `autorizador_id` int(11) unsigned DEFAULT NULL,
  `data_autorizacao` datetime DEFAULT NULL,
  `data_nota` date DEFAULT NULL,
  `valor_nota` decimal(10,2) DEFAULT NULL,
  `numero_nota` varchar(20) DEFAULT NULL,
  `observacao` text,
  `path_nota` varchar(250) DEFAULT NULL,
  `categoria_financeira_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
