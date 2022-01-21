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

/*Table structure for table `relacionamentos` */

DROP TABLE IF EXISTS `relacionamentos`;

CREATE TABLE `relacionamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `membro_id` int(11) unsigned NOT NULL COMMENT 'relaciona?membros:id;nome',
  `tiporelacionamento_id` int(11) unsigned NOT NULL COMMENT 'relaciona?tiporelacionamentos:id;descricao',
  `membro2_id` int(11) unsigned NOT NULL COMMENT 'relaciona?membros:id;nome',
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_relacionamentos_has_membros` (`membro_id`),
  KEY `fk_relacionamentos_has_membros2` (`membro2_id`),
  KEY `fk_relacionamentos_has_tiporelacionamentos` (`tiporelacionamento_id`),
  CONSTRAINT `fk_relacionamentos_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relacionamentos_has_membros2` FOREIGN KEY (`membro2_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relacionamentos_has_tiporelacionamentos` FOREIGN KEY (`tiporelacionamento_id`) REFERENCES `tipo_relacionamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Relacionamentos*Cadastros do relacionamentos do sistema. guarda informações ';

/*Data for the table `relacionamentos` */

insert  into `relacionamentos`(`id`,`membro_id`,`tiporelacionamento_id`,`membro2_id`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,3995,1,3994,1,1,'2018-02-05 20:24:32','2018-02-05 20:24:36');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
