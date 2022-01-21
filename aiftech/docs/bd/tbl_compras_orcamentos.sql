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

/*Table structure for table `compras_orcamentos` */

DROP TABLE IF EXISTS `compras_orcamentos`;

CREATE TABLE `compras_orcamentos` (
  `fornecedores_id` int(11) unsigned NOT NULL,
  `compras_id` int(11) unsigned NOT NULL,
  `orcamento_path` varchar(800) NOT NULL,
  `data_orcamento` date DEFAULT NULL,
  `aprovado` char(1) DEFAULT NULL COMMENT '(S)im ou (N)ão',
  `aprovador_id` int(11) DEFAULT NULL,
  `data_aprovacao` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`fornecedores_id`,`compras_id`),
  KEY `fk_compras` (`compras_id`),
  CONSTRAINT `fk_compras` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`id`),
  CONSTRAINT `fk_fornecedores` FOREIGN KEY (`fornecedores_id`) REFERENCES `fornecedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `compras_orcamentos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
