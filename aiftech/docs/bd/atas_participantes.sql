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

/*Table structure for table `ata_participantes` */

DROP TABLE IF EXISTS `ata_participantes`;

CREATE TABLE `ata_participantes` (
  `ata_id` int(11) unsigned NOT NULL,
  `membro_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ata_id`,`membro_id`),
  KEY `fk_atas_participantes_has_ata` (`ata_id`),
  KEY `ix_ata_participantes` (`membro_id`,`ata_id`),
  CONSTRAINT `fk_atas_participantes_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_atas_participantes_has_membro` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ata_participantes` */

insert  into `ata_participantes`(`ata_id`,`membro_id`) values 
(1,1),
(4,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
