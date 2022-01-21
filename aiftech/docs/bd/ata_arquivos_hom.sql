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

/*Table structure for table `ata_arquivos` */

DROP TABLE IF EXISTS `ata_arquivos`;

CREATE TABLE `ata_arquivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ata_id` int(11) unsigned NOT NULL COMMENT 'relaciona?atas:id;num',
  `path` varchar(200) NOT NULL,
  `nome` varchar(115) NOT NULL,
  `dataupload` date DEFAULT NULL,
  `ata_digit` char(1) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_ata_arquivos_has_atas_idx` (`ata_id`),
  CONSTRAINT `fk_ata_arquivos_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Arquivos de Atas*Tabela Responsavel por armazenar os arquivos das atas e rela';

/*Data for the table `ata_arquivos` */

insert  into `ata_arquivos`(`id`,`ata_id`,`path`,`nome`,`dataupload`,`ata_digit`,`user_id`,`empresa_id`,`created`,`modified`) values 
(1,4,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/2-2017 RCD.pdf','2-2017 RCD.pdf','2018-04-05','S',8,1,'2018-03-09 08:15:47',NULL),
(3,29,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/2-2018 RCD.pdf','2-2018 RCD.pdf','2018-04-05','S',8,1,'2018-04-02 22:48:37',NULL),
(4,27,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/1185 AGO.pdf','1185 AGO.pdf','2018-04-11','S',8,1,'2018-04-02 19:36:12',NULL),
(5,14,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/mpdf (1).pdf','mpdf (1).pdf','2018-04-17','S',8,1,'2018-03-09 10:11:49',NULL),
(6,5,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/mpdf.pdf','mpdf.pdf','2018-04-25','S',1,1,'2018-03-09 08:19:52',NULL),
(7,5,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/mpdf.pdf','mpdf.pdf','2018-04-25','',1,1,'2018-03-09 08:19:52',NULL),
(8,5,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/mpdf (3).pdf','mpdf (3).pdf','2018-04-25','',8,1,'2018-03-09 08:19:52',NULL),
(9,1,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/Ata 1_2017.pdf','Ata 1_2017.pdf','2018-05-03','S',4,1,'2018-03-09 08:03:14',NULL),
(10,5,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/Carta 1o Aviso Desligamento - Romulo dos Santos Silva_temp.pdf','Carta 1o Aviso Desligamento - Romulo dos Santos Silva_temp.pdf','2018-05-03','',8,1,'2018-03-09 08:19:52',NULL),
(11,20,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/Ata 1183 Solene.pdf','Ata 1183 Solene.pdf','2018-05-07','S',4,1,'2018-03-09 09:28:48',NULL),
(12,20,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/Ata 1183 Solene.pdf','Ata 1183 Solene.pdf','2018-05-07','S',4,1,'2018-03-09 09:28:48',NULL),
(13,20,'/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/Atas/Ata 1183 Solene.pdf','Ata 1183 Solene.pdf','2018-05-07','S',4,1,'2018-03-09 09:28:48',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
