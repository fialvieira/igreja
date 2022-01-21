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

/*Table structure for table `local` */

DROP TABLE IF EXISTS `local`;

CREATE TABLE `local` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `sede` char(1) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `ativo` char(1) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  UNIQUE KEY `LOC_NOM` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `local` */

insert  into `local`(`id`,`nome`,`sede`,`empresa_id`,`ativo`,`user_id`,`created`,`modified`) values 
(1,'SALA TORRE 01','S',1,'S',1,'2017-12-04 12:28:28','2017-12-11 20:51:09'),
(2,'SALA 07','S',1,'S',NULL,NULL,NULL),
(3,'SALA 06','S',1,'S',NULL,NULL,NULL),
(4,'CORREDOR 01 (ENTRE SALAS 06 E 07)','S',1,'S',NULL,NULL,NULL),
(5,'SALA I-4 (INVESTIGANDO A BÍBLIA)','S',1,'S',NULL,NULL,NULL),
(6,'SALA I-3 (IDADE DE 7 A 8 ANOS)','S',1,'S',NULL,NULL,NULL),
(7,'SALA (IDADE 4 A 6)','S',1,'S',NULL,NULL,NULL),
(8,'SALA (IDADE 2 A 3 ANOS)','S',1,'S',NULL,NULL,NULL),
(9,'HALL DE ENTRADA','S',1,'S',NULL,NULL,NULL),
(10,'SALA (À DIREITA DA ENTRADA DO HALL)','S',1,'S',NULL,NULL,NULL),
(11,'TEMPLO NAVE','S',1,'S',NULL,NULL,NULL),
(12,'SALÃO SOCIAL','S',1,'S',NULL,NULL,NULL),
(13,'COZINHA','S',1,'S',NULL,NULL,NULL),
(14,'SECRETARIA','S',1,'S',NULL,NULL,NULL),
(15,'GABINENTE PASTORAL','S',1,'S',NULL,NULL,NULL),
(16,'SALA SUPORTE ADMINISTRATIVO','S',1,'S',NULL,NULL,NULL),
(17,'SALA (ANTECEDE A PORTA DOS FUNDOS)','S',1,'S',NULL,NULL,NULL),
(18,'LAVANDERIA','S',1,'S',NULL,NULL,NULL),
(19,'BERÇARIO','S',1,'S',NULL,NULL,NULL),
(20,'Missão em Cabrália Paulista','N',1,'S',NULL,NULL,NULL),
(21,'Recanto Boas Novas','S',1,'S',NULL,NULL,NULL),
(22,'Cristolândia','N',1,'S',NULL,NULL,NULL),
(23,'Projeto Escolinha de Futebol','S',1,'S',NULL,NULL,NULL),
(24,'Gasparini','N',1,'S',NULL,NULL,NULL),
(25,'Sede','N',1,'S',NULL,NULL,NULL),
(26,'SALA DO HALL','S',1,'S',NULL,NULL,NULL),
(27,'SALA DE ESPERA (PASTORAL)','S',1,'S',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
