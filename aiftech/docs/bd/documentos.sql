/*
SQLyog Community v12.09 (64 bit)
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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num` VARCHAR(10) NOT NULL,
  `data` DATE DEFAULT NULL,
  `tipo_documento` INT(11) UNSIGNED NOT NULL,
  `presidencia` INT(10) UNSIGNED DEFAULT NULL,
  `membros` TEXT,
  `igreja_destino_id` INT(11) DEFAULT NULL,
  `pastor_destino_id` INT(10) UNSIGNED DEFAULT NULL,
  `secretario` INT(10) UNSIGNED DEFAULT NULL,
  `finalizado` CHAR(1) DEFAULT 'N',
  `documento_ft` TEXT NOT NULL COMMENT 'oculto',
  `path_arquivo` VARCHAR(200) DEFAULT NULL,
  `data_carta` DATE DEFAULT NULL COMMENT 'data da carta recebida de outra igreja',
  `extensao` CHAR(1) DEFAULT NULL COMMENT '(d)oc; (p)df; (h)tml e (o)dt',
  `user_id` INT(11) DEFAULT NULL COMMENT 'oculto',
  `ata_id` INT(11) UNSIGNED DEFAULT NULL,
  `empresa_id` INT(11) DEFAULT NULL COMMENT 'oculto',
  `created` DATETIME DEFAULT NULL COMMENT 'oculto',
  `modified` DATETIME DEFAULT NULL COMMENT 'oculto',
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
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Documentos*Cadastro de Todas as documentos do Sistema';

/*Table structure for table `documento_tipos` */

DROP TABLE IF EXISTS `documento_tipos`;

CREATE TABLE `documento_tipos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  `path_modelo` VARCHAR(200) DEFAULT NULL,
  `ativo` CHAR(1) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tipos de documento';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
