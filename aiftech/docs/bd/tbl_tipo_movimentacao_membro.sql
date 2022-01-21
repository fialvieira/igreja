/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.22-0ubuntu0.16.04.1 : Database - igreja_hom
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`igreja_hom` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `igreja_hom`;

/*Table structure for table `tipo_movimentacao_membro` */

DROP TABLE IF EXISTS `tipo_movimentacao_membro`;

CREATE TABLE `tipo_movimentacao_membro` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `membros_frequencia_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_movimentacao_membro` */

insert  into `tipo_movimentacao_membro`(`id`,`nome`,`membros_frequencia_id`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Batismo',1,1,1,'2018-02-27 13:58:12','2018-02-27 13:58:15'),
(2,'Aclamação',1,1,1,'2018-02-27 13:58:31','2018-02-27 13:58:34'),
(3,'Recebido por carta',1,1,1,'2018-02-27 13:58:57','2018-02-27 13:58:59'),
(4,'Exclusão a pedido da igreja',4,1,1,'2018-02-27 13:59:18','2018-02-27 13:59:21'),
(5,'Solicitação de carta',19,1,1,'2018-02-27 14:00:06','2018-02-27 14:00:09'),
(6,'Transferência para outra igreja',15,1,1,'2018-02-27 14:00:39','2018-02-27 14:00:41'),
(7,'Desligado por falecimento',8,1,1,'2018-02-27 14:00:59','2018-02-27 14:01:02'),
(8,'Pedido do membro para desligamento',4,1,1,'2018-02-27 14:01:19','2018-02-27 14:01:22'),
(9,'Profissão de fé',NULL,1,1,'2018-02-27 14:01:45','2018-02-27 14:01:47'),
(10,'Reconciliação',1,1,1,'2018-02-27 14:02:00','2018-02-27 14:02:02'),
(11,'Ficha cadastral',NULL,1,1,'2018-07-26 20:57:40','2018-07-26 20:57:43'),
(12,'Termo de admissão de novos membros',NULL,1,1,'2018-07-26 20:58:36','2018-07-26 20:58:39'),
(13,'Autorização para batismo',NULL,1,1,'2018-07-26 20:58:58','2018-07-26 20:59:01'),
(14,'Ausente',2,1,1,'2018-07-27 19:32:43','2018-07-27 19:32:46'),
(15,'Ausente por doença',3,1,1,'2018-07-27 19:33:50','2018-07-27 19:33:52'),
(16,'Aviso de recebimento',2,1,1,'2018-07-27 19:34:27','2018-07-27 19:34:30'),
(17,'Carta enviada',19,1,1,'2018-07-27 19:35:38','2018-07-27 19:35:40'),
(18,'Carta recebida de outra igreja para PIB',1,1,1,'2018-07-27 19:36:28','2018-07-27 19:36:30'),
(19,'Desligado(a) por ausência',5,1,1,'2018-07-27 19:38:45','2018-07-27 19:38:47'),
(20,'Desligado(a) por disciplina',7,1,1,'2018-07-27 19:39:49','2018-07-27 19:39:51'),
(21,'Desligado(a) por mudança de cidade',4,1,1,'2018-07-27 19:40:50','2018-07-27 19:40:52'),
(22,'Em disciplina',6,1,1,'2018-07-27 19:41:16','2018-07-27 19:41:18'),
(23,'Frequência desconhecida',9,1,1,'2018-07-27 19:44:03','2018-07-27 19:44:06'),
(24,'Frequência irregular',10,1,1,'2018-07-27 19:44:35','2018-07-27 19:44:38'),
(25,'Frequenta outra Igreja',11,1,1,'2018-07-27 19:45:04','2018-07-27 19:45:06'),
(26,'Visitante',16,1,1,'2018-07-27 19:46:15','2018-07-27 19:46:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
