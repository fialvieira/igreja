/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.21 : Database - igreja
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

/*Table structure for table `movimentacao_saldo` */

DROP TABLE IF EXISTS `movimentacao_saldo`;

CREATE TABLE `movimentacao_saldo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `conta_financ_id` int(10) unsigned DEFAULT NULL,
  `contas_financ_origem_id` int(10) unsigned DEFAULT NULL,
  `contas_financ_destino_id` int(10) unsigned DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `cancelado` char(1) DEFAULT 'N',
  `user_id_cancela` int(11) DEFAULT NULL,
  `justificativa_cancela` varchar(500) DEFAULT NULL,
  `movimentacao_financeira_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mov_saldo_contas_financ_destino` (`contas_financ_destino_id`),
  KEY `fk_mov_saldo_contas_financ_origem` (`contas_financ_origem_id`),
  CONSTRAINT `fk_mov_saldo_contas_financ_destino` FOREIGN KEY (`contas_financ_destino_id`) REFERENCES `contas_financeira` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mov_saldo_contas_financ_origem` FOREIGN KEY (`contas_financ_origem_id`) REFERENCES `contas_financeira` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
