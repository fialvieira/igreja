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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `situacao` CHAR(1) NOT NULL,
  `solicitante_id` INT(11) UNSIGNED NOT NULL,
  `data_solicitacao` DATETIME NOT NULL,
  `justificativa` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `autorizador_id` INT(11) UNSIGNED DEFAULT NULL,
  `data_autorizacao` DATETIME DEFAULT NULL,
  `data_nota` DATE DEFAULT NULL,
  `valor_nota` DECIMAL(10,2) DEFAULT NULL,
  `numero_nota` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `observacao` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
  `path_nota` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
