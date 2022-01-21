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

/*Table structure for table `ata_tipos` */

DROP TABLE IF EXISTS `ata_tipos`;

CREATE TABLE `ata_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `ativo` char(1) NOT NULL,
  `texto_padrao` text,
  `cartorio` char(1) NOT NULL COMMENT 'Tipo é registrado em cartório (S)im / (N)ão',
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Tipos de Ata';

/*Data for the table `ata_tipos` */

insert  into `ata_tipos`(`id`,`descricao`,`ativo`,`texto_padrao`,`cartorio`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Reunião do Conselho Diretor','S','da (b)#TIPO(/b) da #IGREJA realizada no dia (b)#DATA(/b) (#DATA_EXTENSO) em seu templo localizado na #ENDERECO. Presidida pelo irmão #PRESIDENTE, presidente em exercício, com início às (b)hh:mm(/b) (hh horas e mm minutos), com a presença de (b)XX(/b) (XXXXXXXXX) membros: ','N',1,7,'2017-11-29 17:33:49','2018-04-03 11:16:15'),
(2,'Assembleia Geral Extraordinária','S','da (b)#TIPO(/b) da #IGREJA realizada no dia (b)#DATA(/b) (#DATA_EXTENSO) em seu templo localizado na #ENDERECO, sob a presidência do irmão #PRESIDENTE, declara aberta às (b)hh:mm(/b) (hh horas e mm minutos), em primeira convocação iniciando a contagem de membros presentes, não havendo quórum aguardou-se o tempo regimental e declarou aberta a Assembleia em segunda convocação às (b)hh:mm(/b) (hh horas e mm minutos), com (b)XX(/b) (XXXXXXXXX) membros presentes. O presidente, irmão #PRESIDENTE deu início a assembleia com a leitura da ordem do dia, como segue:(b)XXXXXXXXX XXXXXXXXX(/b), passada a palavra para o pastor Jeferson Rodolfo Cristianini, que discorreu ','S',1,7,'2017-11-29 17:40:40','2018-04-03 11:16:54'),
(3,'Assembleia Geral Ordinária','S','da (b)#TIPO(/b) da #IGREJA realizada no dia (b)#DATA(/b) (#DATA_EXTENSO) em seu templo localizado na #ENDERECO. sob a presidência do irmão #PRESIDENTE, que declarou aberta a Assembleia às (b)hh:mm(/b) (hh horas e mm minutos), com (b)XX(/b) (XXXXX) membros presentes. O Presidente declarou aberta a assembleia e passou a palavra ao secretário para ler a ordem do dia, que foi aprovada pelo plenário como segue:','S',1,7,'2017-11-29 17:41:23','2018-04-03 11:17:11'),
(4,'Assembleia Solene Profissão de Fé','S','da (b)#TIPO(/b) da #IGREJA realizada no dia (b)#DATA(/b) (#DATA_EXTENSO) em seu templo localizado na #ENDERECO, sob a presidência do Pastor #PRESIDENTE. Foi declarada aberta a assembleia às (b)hh:mm(/b) (hh horas e mm minutos), tendo o Pastor efetivado a pública Profissao de Fé dos irmãos: (b)nome(/b), estado civil, endereço, data nascimento; (b)nome(/b), estado civil, endereço, data nascimento; Os irmãos foram submetidos à Profissão de Fé, sendo arguida sobre sua salvação por Jesus, sobre a doutrina Batista e sobre o governo da Igreja, e responderam com muita segurança todas as perguntas formuladas pelo Pastor. Na sequência a Igreja deliberou, por unanimidade, pela recepção destes irmãos como membros de nossa Igreja. Na sequência o Pastor Titular da Igreja e presidente desta Assembleia solene, #PRESIDENTE, encerrou-se a assembleia. ','S',1,7,'2017-11-29 17:41:56','2018-04-03 11:17:36'),
(5,'Assembleia Solene Batismo','S','da (b)#TIPO(/b) da #IGREJA realizada no dia (b)#DATA(/b) (#DATA_EXTENSO) em seu templo localizado na #ENDERECO, sob a presidência do Pastor #PRESIDENTE. Foi declarada aberta a assembleia às (b)hh:mm(/b) (hh horas e mm minutos), quando o pastor #PRESIDENTE, realizou os batismos dos irmãos: (b)nome 1, nome 2,...(/b).   ','S',1,7,'2018-04-03 11:11:02','2018-04-03 11:14:52');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
