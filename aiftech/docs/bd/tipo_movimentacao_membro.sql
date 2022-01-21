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

/*Table structure for table `tipo_movimentacao_membro` */

DROP TABLE IF EXISTS `tipo_movimentacao_membro`;

CREATE TABLE `tipo_movimentacao_membro` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_movimentacao_membro` */

insert  into `tipo_movimentacao_membro`(`id`,`nome`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Batismo',1,1,'2018-02-27 13:58:12','2018-02-27 13:58:15'),
(2,'Aclamação',1,1,'2018-02-27 13:58:31','2018-02-27 13:58:34'),
(3,'Recebido por carta',1,1,'2018-02-27 13:58:57','2018-02-27 13:58:59'),
(4,'Exclusão a pedido da igreja',1,1,'2018-02-27 13:59:18','2018-02-27 13:59:21'),
(5,'Solicitação de carta',1,1,'2018-02-27 14:00:06','2018-02-27 14:00:09'),
(6,'Transferência para outra igreja',1,1,'2018-02-27 14:00:39','2018-02-27 14:00:41'),
(7,'Falecido(a)',1,1,'2018-02-27 14:00:59','2018-02-27 14:01:02'),
(8,'Pedido do membro para desligamento',1,1,'2018-02-27 14:01:19','2018-02-27 14:01:22'),
(9,'Profissão de fé',1,1,'2018-02-27 14:01:45','2018-02-27 14:01:47'),
(10,'Reconciliação',1,1,'2018-02-27 14:02:00','2018-02-27 14:02:02');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
