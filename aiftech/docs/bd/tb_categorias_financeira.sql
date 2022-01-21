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

/*Table structure for table `categorias_financeira` */

DROP TABLE IF EXISTS `categorias_financeira`;

CREATE TABLE `categorias_financeira` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `tipo` char(1) NOT NULL,
  `categoria_mae` int(11) unsigned DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `categorias_financeira` */

insert  into `categorias_financeira`(`id`,`num`,`nome`,`descricao`,`tipo`,`categoria_mae`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'3.1','Receitas Regulares',NULL,'R',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(2,'2.1','Despesas com Pessoal',NULL,'D',NULL,'N',1,1,'2018-06-11 09:54:28','2018-06-24 14:17:49'),
(3,'2.2','Despesas Administrativas',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(4,'2.3','Despesas Ecleseásticas',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(5,'2.4','Despesas Ministeriais',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(6,'2.5','Fundo para Construção',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(7,'3.1.1','Dízimos e Ofertas Normais',NULL,'R',1,'S',1,7,'2018-06-11 09:54:28',NULL),
(8,'3.1.2','Gasofilácio Transparente',NULL,'R',1,'S',1,7,'2018-06-11 09:54:28',NULL),
(9,'2.1.1','13º Salário / Férias',NULL,'D',2,'N',1,1,'2018-06-11 09:54:28','2018-06-24 14:13:23'),
(10,'2.1.2','Encargos Sociais (FGTS/INSS/PIS)',NULL,'D',2,'N',1,1,'2018-06-11 09:54:28','2018-06-24 14:12:50'),
(11,'2.1.3','FGTM - Fundo de Garantia',NULL,'D',2,'N',1,1,'2018-06-11 09:54:28','2018-06-24 14:17:47'),
(12,'2.2.1','Água e Esgoto',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(13,'2.2.2','Aquisição de Patrimônio',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(14,'2.2.3','Assessoria Contábil',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(15,'2.3.1','A.B.C.E.S.P (Associação)',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(16,'2.3.2','Auxílio à Cristolândia',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(17,'2.3.3','Auxílio a outras Igrejas',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(18,'2.4.2','Verba de Ministérios',NULL,'D',5,'S',1,7,'2018-06-11 09:54:28',NULL),
(20,'2.1.4','Outros Tipos Despesas','Outros tipos de despesas.','D',2,'N',1,1,'2018-06-23 21:20:53','2018-06-24 14:12:48'),
(21,'2.1.4.1','Médica','Despesas médicas com pessoal.','D',20,'N',1,1,'2018-06-23 21:32:44','2018-06-24 14:12:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
