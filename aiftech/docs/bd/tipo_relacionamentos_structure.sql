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

/*Table structure for table `tipo_relacionamentos` */

DROP TABLE IF EXISTS `tipo_relacionamentos`;

CREATE TABLE `tipo_relacionamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET latin1 NOT NULL,
  `obs` text CHARACTER SET latin1,
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Tipo Relacionamentos*Cadastro de Tipo de Relacionamento. Responsável por armazena';

/*Data for the table `tipo_relacionamentos` */

insert  into `tipo_relacionamentos`(`id`,`descricao`,`obs`,`user_id`,`created`,`modified`) values 
(1,'Pai',NULL,1,'2018-02-05 13:20:47','2018-02-05 13:20:49'),
(2,'Mãe',NULL,1,'2018-02-05 13:21:24','2018-02-05 13:21:26'),
(3,'Cônjuge',NULL,1,'2018-02-05 13:22:06','2018-02-05 13:22:09'),
(4,'Filho(a)',NULL,1,'2018-02-05 13:22:26','2018-02-05 13:22:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
