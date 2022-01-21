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

/*Table structure for table `movimentacao_membros` */

DROP TABLE IF EXISTS `movimentacao_membros`;

CREATE TABLE `movimentacao_membros` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `membro_id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `ata_id` int(11) unsigned DEFAULT NULL,
  `carta_id` int(11) unsigned DEFAULT NULL,
  `carta_recebimento_path` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_movimentacao_membro_id` int(11) unsigned DEFAULT NULL,
  `data_carta_recebimento` date DEFAULT NULL,
  `observacao` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `movimentacao_membros` */

insert  into `movimentacao_membros`(`id`,`membro_id`,`empresa_id`,`ata_id`,`carta_id`,`carta_recebimento_path`,`tipo_movimentacao_membro_id`,`data_carta_recebimento`,`observacao`,`user_id`,`created`,`modified`) values 
(1,3995,1,1,1,NULL,3,NULL,'Teste.',1,'2018-03-24 18:33:58','2018-03-24 18:34:01');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
