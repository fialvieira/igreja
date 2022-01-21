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

/*Table structure for table `nucleos` */

DROP TABLE IF EXISTS `nucleos`;

CREATE TABLE `nucleos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_fundacao` date DEFAULT NULL,
  `ativo` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `nucleos` */

insert  into `nucleos`(`id`,`nome`,`data_fundacao`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Altos Da Cidade ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(2,'Bela Vista ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(3,'Centro ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(4,'Falcão ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(5,'Mary Dota ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(6,'Geisel',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(7,'Independência ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(8,'Jaraguá ',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(9,'Jardim América',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(10,'Jardim Ferraz',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(11,'Universitária ','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(12,'Higienópolis ','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(13,'Vista Alegre','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(14,'Jardim Panorama','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(15,'Vila Giunta','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(16,'Parque Roosevelt','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(17,'Alto Paraíso','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(18,'Santa Clara','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(19,'Octávio Rasi','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(20,'Terra Branca','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(21,'Novo 1 - Industrial','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(22,'Novo 2 - Pagani','2017-01-01','S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40'),
(23,'Novo 3 - Marambá',NULL,'S',1,NULL,'2018-01-24 18:53:40','2018-01-24 18:53:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
