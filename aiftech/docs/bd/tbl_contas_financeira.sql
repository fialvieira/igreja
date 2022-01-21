/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.23-0ubuntu0.16.04.1 : Database - igreja_hom
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

/*Table structure for table `contas_financeira` */

DROP TABLE IF EXISTS `contas_financeira`;

CREATE TABLE `contas_financeira` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `banco_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?bancos:id;nome',
  `agencia` varchar(10) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `variacao` varchar(5) DEFAULT NULL,
  `tipo_conta` char(1) NOT NULL COMMENT 'combo?Corrente;Aplicação',
  `tipo_aplicacao` char(1) DEFAULT NULL COMMENT 'combo?Própria;Transitória',
  `ativo` char(1) DEFAULT 'S',
  `saldo_inicial` decimal(10,2) DEFAULT '0.00',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_contas_has_banco` (`banco_id`),
  CONSTRAINT `fk_contas_has_banco` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `contas_financeira` */

insert  into `contas_financeira`(`id`,`nome`,`descricao`,`banco_id`,`agencia`,`numero`,`variacao`,`tipo_conta`,`tipo_aplicacao`,`ativo`,`saldo_inicial`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Conta Corrente','Conta Corrente da PIBB',7,'0290','4688-7','003','C','P','S',10458.96,1,4,'2018-08-11 11:49:43','2018-08-15 22:26:29'),
(2,'Fundo de Reserva','Conta Poupança',7,'0290','221299-4','013','A','P','S',43159.15,1,4,'2018-08-11 11:51:45','2018-08-15 22:27:26'),
(3,'Fundo de Missões','Conta Poupança',7,'0290','221300-1','013','A','P','S',7044.58,1,4,'2018-08-11 11:52:53','2018-08-15 22:28:15'),
(4,'Fundo de Ministerios','Conta Poupança',7,'0290','221301-0','013','A','P','S',NULL,1,4,'2018-08-11 11:54:02','2018-08-15 22:28:42'),
(5,'Fundo de Provisões','Conta Poupança',7,'0290','221302-8','013','A','P','S',15237.63,1,4,'2018-08-11 11:55:24','2018-08-15 22:26:58'),
(6,'FGTM - Pr Titular','Conta Poupança',7,'0290','221303-6','013','A','P','S',12955.10,1,4,'2018-08-11 11:56:43','2018-08-15 22:27:56'),
(7,'Fundo de Construção','Conta Poupança',7,'0290','221304-4','013','A','T','S',NULL,1,4,'2018-08-11 11:57:37','2018-08-15 22:28:56'),
(8,'FGTM - Pr. Cabralia','Conta Poupança',7,'0290','232474-1','013','A','P','S',0.00,1,4,'2018-08-11 11:58:44','2018-08-15 22:29:39'),
(9,'Aplicação (Fundos DI) ','Aplicação (Fundo de Construção)',7,'0290','4688-7','003','A','P','S',NULL,1,4,'2018-08-11 12:00:42','2018-08-15 22:30:18'),
(10,'Conta Caixa - Tesouraria',NULL,NULL,NULL,NULL,NULL,'V',NULL,'S',0.00,1,1,'2018-08-21 22:46:25','2018-08-22 20:54:16'),
(11,'Conta Caixa - Secretaria',NULL,NULL,NULL,NULL,NULL,'V',NULL,'S',NULL,1,1,'2018-08-21 22:46:54','2018-08-22 20:54:23'),
(12,'Valores a receber',NULL,NULL,NULL,NULL,NULL,'R',NULL,'S',0.00,1,1,'2018-09-04 17:52:11','2018-09-04 17:52:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
