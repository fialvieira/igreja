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

/*Table structure for table `produtos` */

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE `produtos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci,
  `unidade_medida` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ativo` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `tipo` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P',
  `tipo_produto_id` int(11) unsigned DEFAULT NULL,
  `fornecedor_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produtos_has_tipo_produtos` (`tipo_produto_id`),
  CONSTRAINT `produtos_has_tipo_produtos` FOREIGN KEY (`tipo_produto_id`) REFERENCES `tipo_produtos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `produtos` */

insert  into `produtos`(`id`,`nome`,`descricao`,`unidade_medida`,`ativo`,`tipo`,`tipo_produto_id`,`fornecedor_id`,`empresa_id`,`user_id`,`created`,`modified`) values (1,'Cola','Cola','5','S','P',8,NULL,1,1,'2018-03-14 16:43:49','2018-03-14 16:43:51');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
