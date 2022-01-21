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
USE `igreja`;

/*Table structure for table `centro_custo` */

DROP TABLE IF EXISTS `centro_custo`;

CREATE TABLE `centro_custo` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) CHARACTER SET latin1 NOT NULL,
  `ativo` CHAR(1) DEFAULT NULL,
  `empresa_id` INT(11) NOT NULL COMMENT 'oculto',
  `user_id` INT(11) NOT NULL COMMENT 'oculto',
  `created` DATETIME NOT NULL COMMENT 'oculto',
  `modified` DATETIME DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UNIQUE` (`descricao`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `centro_custo` */

INSERT  INTO `centro_custo`(`id`,`descricao`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) VALUES (1,'Sede','S',1,7,'2018-06-11 09:54:28',NULL),(2,'Cristolândia','S',1,7,'2018-06-11 09:54:28',NULL),(3,'Gasparini','S',1,7,'2018-06-11 09:54:28',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
