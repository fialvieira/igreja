/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.25-0ubuntu0.16.04.2 : Database - igreja_hom
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

/*Table structure for table `mov_fin_arquivos` */

DROP TABLE IF EXISTS `mov_fin_arquivos`;

CREATE TABLE `mov_fin_arquivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `movimentacao_financeira_id` int(11) unsigned NOT NULL,
  `path` varchar(200) NOT NULL,
  `nome` varchar(115) NOT NULL,
  `dataupload` date NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_mov_fin_arquivos_has_movimentacao_financeira_idx` (`movimentacao_financeira_id`),
  CONSTRAINT `fk_mov_fin_arquivos_has_movimentacao_financeira_idx` FOREIGN KEY (`movimentacao_financeira_id`) REFERENCES `movimentacao_financeira` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tabela Responsavel por armazenar os arquivos dos lançamentos diários (movimentação financeira)';

/*Data for the table `mov_fin_arquivos` */

insert  into `mov_fin_arquivos`(`id`,`movimentacao_financeira_id`,`path`,`nome`,`dataupload`,`user_id`,`empresa_id`,`created`,`modified`) values 
(1,195,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Movimentacao_Financeira/20180903-212203_Ata 1_2017.pdf','Ata 1_2017.pdf','2018-09-03',9,1,'2018-09-03 21:22:05',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
