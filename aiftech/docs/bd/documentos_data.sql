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

/*Table structure for table `documentos` */

DROP TABLE IF EXISTS `documentos`;

CREATE TABLE `documentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` varchar(10) NOT NULL,
  `data` date DEFAULT NULL,
  `tipo_documento` int(11) unsigned NOT NULL,
  `presidencia` int(10) unsigned DEFAULT NULL,
  `membros` text,
  `igreja_destino_id` int(11) DEFAULT NULL,
  `pastor_destino_id` int(10) unsigned DEFAULT NULL,
  `secretario` int(10) unsigned DEFAULT NULL,
  `finalizado` char(1) DEFAULT 'N',
  `documento_ft` text NOT NULL COMMENT 'oculto',
  `path_arquivo` varchar(200) DEFAULT NULL,
  `data_carta` date DEFAULT NULL COMMENT 'data da carta recebida de outra igreja',
  `extensao` char(1) DEFAULT NULL COMMENT '(d)oc; (p)df; (h)tml e (o)dt',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `ata_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `presidencia` (`presidencia`),
  KEY `secretario` (`secretario`),
  KEY `igreja_destino` (`igreja_destino_id`),
  KEY `pastor_destino` (`pastor_destino_id`),
  FULLTEXT KEY `Fultext_ix` (`documento_ft`),
  CONSTRAINT `fk_documentos_igreja_destino` FOREIGN KEY (`igreja_destino_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documentos_membros_presidencia` FOREIGN KEY (`presidencia`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documentos_membros_secretario` FOREIGN KEY (`secretario`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documentos_pastor_destino` FOREIGN KEY (`pastor_destino_id`) REFERENCES `pastores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Documentos*Cadastro de Todas as documentos do Sistema';

/*Data for the table `documentos` */

insert  into `documentos`(`id`,`num`,`data`,`tipo_documento`,`presidencia`,`membros`,`igreja_destino_id`,`pastor_destino_id`,`secretario`,`finalizado`,`documento_ft`,`path_arquivo`,`data_carta`,`extensao`,`user_id`,`ata_id`,`empresa_id`,`created`,`modified`) values (1,'1/2018','2018-03-23',1,3842,'3995',127,6,3994,'N','1 1/2018 23/03/2018 DIA:23 MES:03 ANO:2018 1 Jeferson Rodolfo Cristianini \n                                       Rômulo dos Santos Silva                                      undefined    Elaine Gisele Bendelaque Silva','C:\\wamp\\www\\projeto_igreja\\aiftech\\arquivos\\empresa_id_1\\Teste_asdfaf.pdf','2018-03-26',NULL,7,NULL,1,'2018-03-23 17:33:43','2018-03-23 18:28:48');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
