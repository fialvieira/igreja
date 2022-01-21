/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.29-0ubuntu0.16.04.1 : Database - igreja
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

/*Table structure for table `movimentacao_financeira` */

DROP TABLE IF EXISTS `movimentacao_financeira`;

CREATE TABLE `movimentacao_financeira` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` char(1) NOT NULL COMMENT '(E)ntrada/Receita ou (S)aída/Despesa',
  `data` date NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `documento` varchar(20) DEFAULT NULL COMMENT 'Campo para gravar o número do recibo, Nota Fiscal, etc.',
  `categoria_financeira_id` int(10) unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `centro_custo_id` int(11) unsigned NOT NULL,
  `membro_id` int(11) unsigned DEFAULT NULL,
  `cancelado` char(1) DEFAULT NULL COMMENT 'Indica se o lançamento foi cancelado pelo responsável (S)im ou (N)ão',
  `user_id_cancela` int(11) DEFAULT NULL,
  `justifica_cancela` text,
  `contas_financeira_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
