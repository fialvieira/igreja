/*
SQLyog Ultimate v12.09 (64 bit)
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

/*Table structure for table `tipo_produtos` */

DROP TABLE IF EXISTS `tipo_produtos`;

CREATE TABLE `tipo_produtos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ativo` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_produtos` */

insert  into `tipo_produtos`(`id`,`nome`,`descricao`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) values (1,'Limpeza','Produtos de limpeza em geral.','S',1,1,'2018-03-09 15:48:33','2018-03-12 13:47:09'),(2,'Higiene pessoal','Higiene pessoal','S',1,1,'2018-03-09 15:48:53','2018-03-09 15:48:56'),(3,'Hortifruti','Hortifruti','S',1,1,'2018-03-09 15:50:41','2018-03-09 15:50:44'),(4,'Açougue','Açougue','S',1,1,'2018-03-09 15:51:03','2018-03-09 15:51:06'),(5,'Padaria','Padaria','S',1,1,'2018-03-09 15:52:20','2018-03-09 15:52:22'),(6,'Confeitaria','Confeitaria','S',1,1,'2018-03-09 15:52:32','2018-03-09 15:52:35'),(7,'Frios e laticínios','Frios e laticínios','S',1,1,'2018-03-09 15:53:28','2018-03-09 15:53:30'),(8,'Papelaria','Papelaria','S',1,1,'2018-03-09 15:54:44','2018-03-09 15:54:46'),(9,'Informática','Informática','S',1,1,'2018-03-09 15:55:14','2018-03-09 15:55:17'),(10,'Eletrodoméstico','Eletrodoméstico','S',1,1,'2018-03-09 15:59:00','2018-03-09 15:59:02'),(11,'Escritório','Materiais para escritório.','N',1,1,'2018-03-12 13:51:07','2018-03-12 13:51:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
