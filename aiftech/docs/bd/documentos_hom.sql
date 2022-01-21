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

/*Table structure for table `documentos` */

DROP TABLE IF EXISTS `documentos`;

CREATE TABLE `documentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` varchar(10) NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Documentos*Cadastro de Todas as documentos do Sistema';

/*Data for the table `documentos` */

insert  into `documentos`(`id`,`num`,`data`,`hora`,`tipo_documento`,`presidencia`,`membros`,`igreja_destino_id`,`pastor_destino_id`,`secretario`,`finalizado`,`documento_ft`,`path_arquivo`,`data_carta`,`extensao`,`user_id`,`ata_id`,`empresa_id`,`created`,`modified`) values 
(1,'1/2018','2018-03-23',NULL,1,3842,'3995',127,6,3994,'N','1 1/2018 23/03/2018 DIA:23 MES:03 ANO:2018 1 Carta 1º Aviso Desligamento Jeferson Rodolfo Cristianini \n                                       Rômulo dos Santos Silva                                      1174  1ª Igreja Batista de Araçatuba  Elaine Gisele Bendelaque Silva','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/Carta 1o Aviso Desligamento - Romulo dos Santos Silva_temp.docx',NULL,NULL,8,5,1,'2018-03-23 17:33:43','2018-05-03 12:38:54'),
(2,'2/2018','2018-03-26',NULL,5,3842,'4274',126,NULL,3994,'N','  26/03/2018 DIA:26 MES:03 ANO:2018 5  Monique de Moura Bordin    1174  Pongaí  ',NULL,NULL,NULL,7,5,1,'2018-03-26 16:20:20','2018-03-26 16:20:20'),
(3,'3/2018','2018-02-25','19:00:00',8,3842,'3985',NULL,NULL,3994,'N','3 3/2018 25/02/2018 DIA:25 MES:02 ANO:2018 8 Termo de Posse Cabrália Paulista Jeferson Rodolfo Cristianini \n                                       Davi Alves                                      1180    Elaine Gisele Bendelaque Silva','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/Termo de Posse Cabralia Paulista - Davi Alves_temp (3).docx',NULL,NULL,4,17,1,'2018-03-27 08:15:02','2018-04-26 08:42:28'),
(4,'4/2018','2018-04-25','10:00:00',1,3842,'3995',45,12,3994,'N','  25/04/2018 DIA:25 MES:04 ANO:2018 1 Carta 1º Aviso Desligamento  Rômulo dos Santos Silva    1174  1ª Igreja Batista Boas Novas Jaú Antônio Carlos ',NULL,NULL,NULL,1,5,1,'2018-04-25 17:33:01','2018-04-25 17:33:01'),
(5,'5/2018','2018-04-25','10:00:00',1,3842,NULL,45,12,3994,'N','5 5/2018 25/04/2018 DIA:25 MES:04 ANO:2018 1 Carta 1º Aviso Desligamento Jeferson Rodolfo Cristianini  1174  1ª Igreja Batista Boas Novas Jaú Antônio Carlos Elaine Gisele Bendelaque Silva',NULL,NULL,NULL,1,5,1,'2018-04-25 17:33:30','2018-04-25 17:33:32'),
(6,'6/2018','2018-05-02','10:00:00',3,3842,'4146',NULL,NULL,3994,'N','  02/05/2018 DIA:02 MES:05 ANO:2018 3 Carta Desligamento Pedido Membro  Ilidia Luzia Cândido de Marco Vertelo    8/2017    ',NULL,NULL,NULL,8,13,1,'2018-05-02 16:32:13','2018-05-02 16:32:13'),
(7,'7/2018','2018-05-02','10:00:00',3,3842,NULL,88,17,3994,'N','  02/05/2018 DIA:02 MES:05 ANO:2018 3 Carta Desligamento Pedido Membro   8/2017  1ª Igreja Batista de Guaianazes Paulo Moreira ',NULL,NULL,NULL,8,13,1,'2018-05-02 16:32:45','2018-05-02 16:32:45'),
(8,'8/2018','2018-05-02','10:00:00',3,3842,NULL,88,17,3994,'N','  02/05/2018 DIA:02 MES:05 ANO:2018 3 Carta Desligamento Pedido Membro   8/2017  1ª Igreja Batista de Guaianazes Paulo Moreira ',NULL,NULL,NULL,8,13,1,'2018-05-02 16:33:28','2018-05-02 16:33:28'),
(9,'9/2018','2018-05-02','10:00:00',1,3842,'4146',NULL,NULL,3994,'N','  02/05/2018 DIA:02 MES:05 ANO:2018 1 Carta 1º Aviso Desligamento  Ilidia Luzia Cândido de Marco Vertelo    8/2017    ',NULL,NULL,NULL,8,13,1,'2018-05-02 16:37:14','2018-05-02 16:37:14'),
(10,'10/2018','2018-05-02','10:00:00',5,3842,'4146',NULL,NULL,3994,'N','10 10/2018 02/05/2018 DIA:02 MES:05 ANO:2018 5 Carta Solicitação Entrada Membro Jeferson Rodolfo Cristianini Ilidia Luzia Cândido de Marco Vertelo    8/2017    Elaine Gisele Bendelaque Silva',NULL,NULL,NULL,8,13,1,'2018-05-02 16:37:50','2018-05-02 16:37:55'),
(11,'11/2018','2018-05-07','10:00:00',5,3842,'4504',96,1,3994,'N','11 11/2018 07/05/2018 DIA:07 MES:05 ANO:2018 5 Carta Solicitação Entrada Membro Jeferson Rodolfo Cristianini David Pedro    1184  2ª Igreja Batista em Campo Grande Jeferson Rodolfo Cristianni Elaine Gisele Bendelaque Silva',NULL,NULL,NULL,8,26,1,'2018-05-06 16:55:39','2018-05-06 16:56:13'),
(12,'12/2018','2018-05-07','10:00:00',5,3842,'3879',96,1,3994,'N','12 12/2018 07/05/2018 DIA:07 MES:05 ANO:2018 5 Carta Solicitação Entrada Membro Jeferson Rodolfo Cristianini Marcelo Teodoro de Souza    1184  2ª Igreja Batista em Campo Grande  Elaine Gisele Bendelaque Silva',NULL,NULL,NULL,4,26,1,'2018-05-06 16:56:26','2018-05-07 09:01:16'),
(13,'13/2018','2018-05-07',NULL,5,3842,'4503,4504',173,NULL,3994,'N','13 13/2018 07/05/2018 DIA:07 MES:05 ANO:2018 5 Carta Solicitação Entrada Membro Jeferson Rodolfo Cristianini \n                                        Yindu Ivette Pedro                                     \n                                        David Pedro                                        2ª Igreja Batista em Osasco  Elaine Gisele Bendelaque Silva','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/Carta Solicitacao Entrada Membro - 07-05-2018.docx',NULL,NULL,10,NULL,1,'2018-05-11 18:57:07','2018-05-11 19:27:05');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
