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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

/*Data for the table `categorias_financeira` */

insert  into `categorias_financeira`(`id`,`num`,`nome`,`descricao`,`tipo`,`categoria_mae`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'3.1','Receitas Regulares',NULL,'R',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(2,'2.1','Despesas com Pessoal',NULL,'D',2,'S',1,7,'2018-06-11 09:54:28','2018-06-25 07:49:35'),
(3,'2.2','Despesas Administrativas',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28','2018-06-25 07:50:03'),
(4,'2.3','Despesas Ecleseásticas',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(5,'2.4','Despesas Ministeriais',NULL,'D',NULL,'S',1,7,'2018-06-11 09:54:28',NULL),
(6,'2.2.5','Fundo para Construção',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28','2018-06-27 10:17:00'),
(7,'3.1.1','Dízimos e Ofertas Normais',NULL,'R',1,'S',1,7,'2018-06-11 09:54:28',NULL),
(8,'3.1.2','Gasofilácio Transparente',NULL,'R',1,'S',1,7,'2018-06-11 09:54:28',NULL),
(9,'2.1.1','13º Salário / Férias',NULL,'D',2,'S',1,1,'2018-06-11 09:54:28','2018-06-24 14:27:30'),
(10,'2.1.2','Encargos Sociais (FGTS/INSS/PIS)',NULL,'D',2,'S',1,9,'2018-06-11 09:54:28','2018-06-26 12:42:55'),
(11,'2.1.3','FGTM - Fundo de Garantia',NULL,'D',2,'S',1,1,'2018-06-11 09:54:28','2018-06-24 14:27:32'),
(12,'2.2.1','Água e Esgoto',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(13,'2.2.2','Aquisição de Patrimônio',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(14,'2.2.3','Assessoria Contábil',NULL,'D',3,'S',1,7,'2018-06-11 09:54:28',NULL),
(15,'2.3.1','A.B.C.E.S.P (Associação)',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(16,'2.3.2','Auxílio à Cristolândia',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(17,'2.3.3','Auxílio a outras Igrejas',NULL,'D',4,'S',1,7,'2018-06-11 09:54:28',NULL),
(18,'2.4.2','Verba de Ministérios',NULL,'D',5,'S',1,7,'2018-06-11 09:54:28',NULL),
(20,'2.1.4','Outros Tipos Despesas','Outros tipos de despesas.','D',2,'S',1,1,'2018-06-23 21:20:53','2018-06-24 14:27:33'),
(21,'2.1.4.1','Médica','Despesas médicas com pessoal.','D',20,'S',1,1,'2018-06-23 21:32:44','2018-06-24 14:27:33'),
(26,'3.1.4','Campanha Missões Estaduais',NULL,'R',1,'S',1,7,'2018-06-26 10:10:46','2018-06-27 10:04:07'),
(29,'2.4.4','Jovens','Ministério de Jovens','D',5,'S',1,7,'2018-06-26 14:37:49','2018-06-27 09:53:45'),
(30,'3.1.3','Entradas Transitórias','Ofertas Destinadas','R',1,'S',1,4,'2018-06-26 14:41:38','2018-06-26 14:41:38'),
(31,'2.1.4.5','FGTS','Despesas com o depósito FGTS.','D',20,'S',1,1,'2018-06-26 18:57:06','2018-06-26 18:57:06'),
(32,'2.2.4','Material de Escritorio',NULL,'D',3,'S',1,8,'2018-06-27 08:32:50','2018-06-27 08:32:50'),
(33,'2.4.1','Acampamentos','inscrições em acampamentos','D',5,'S',1,7,'2018-06-27 09:52:11','2018-06-27 09:52:11'),
(36,'2.6','Despesa com Veiculo','despesa com veiculo','D',NULL,'S',1,7,'2018-06-27 10:00:51','2018-06-27 10:00:51'),
(37,'2.6.1','Revisão',NULL,'D',36,'S',1,7,'2018-06-27 10:02:28','2018-06-27 10:02:28'),
(38,'2.6.2','Peças',NULL,'D',36,'S',1,7,'2018-06-27 10:02:56','2018-06-27 10:03:11'),
(39,'2.6.3','Combustivel',NULL,'D',36,'S',1,7,'2018-06-27 10:04:55','2018-06-27 10:04:55'),
(40,'2.6.4','Lavagem',NULL,'D',36,'S',1,7,'2018-06-27 10:05:17','2018-06-27 10:05:29'),
(41,'2.4.5','Embaixadores do Rei',NULL,'D',5,'S',1,7,'2018-06-27 10:09:06','2018-06-27 10:09:06'),
(42,'2.4.5.1','Acampamento Estadual',NULL,'D',41,'S',1,7,'2018-06-27 10:09:37','2018-06-27 10:09:37'),
(43,'2.4.5.2','Uniforme',NULL,'D',41,'S',1,7,'2018-06-27 10:09:56','2018-06-27 10:11:24'),
(44,'2.4.5.3','Revista',NULL,'D',41,'S',1,7,'2018-06-27 10:10:20','2018-06-27 10:10:20'),
(45,'2.4.5.4','Manual de Postos',NULL,'D',41,'S',1,7,'2018-06-27 10:10:39','2018-06-27 10:11:39'),
(46,'2.4.6','Mulheres','Despesa com o ministerio de mulheres','D',5,'S',1,7,'2018-06-27 10:14:34','2018-06-27 10:14:34'),
(47,'2.4.6.1','Aluguel Retiro','despesa com o retiro','D',46,'S',1,7,'2018-06-27 10:15:10','2018-06-27 10:15:10'),
(48,'2.4.6.2','Combustivel',NULL,'D',46,'S',1,7,'2018-06-27 10:15:35','2018-06-27 10:16:18'),
(49,'2.4.6.3','Alimentação',NULL,'D',46,'S',1,7,'2018-06-27 10:16:05','2018-06-27 10:16:05'),
(50,'2.4.5.5','Curso de Conselheiro',NULL,'D',41,'S',1,7,'2018-06-27 10:17:39','2018-06-27 10:17:39'),
(51,'2.4.5.6','Combustivel',NULL,'D',41,'S',1,7,'2018-06-27 10:18:06','2018-06-27 10:18:06'),
(52,'2.4.5.6','Pedagio',NULL,'D',41,'S',1,7,'2018-06-27 10:18:19','2018-06-27 10:18:19'),
(53,'3.1.5','Doações teste','teste de doações','R',1,'S',1,7,'2018-06-27 10:20:43','2018-06-27 10:20:43'),
(54,'3.1.3.1','Ministerio Mensageiras do rei','Conta Destinada as Entradas do Ministerio x','R',30,'S',1,4,'2018-07-03 15:56:06','2018-07-03 15:56:06');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
