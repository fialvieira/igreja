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

/*Table structure for table `menu_modulos` */

DROP TABLE IF EXISTS `menu_modulos`;

CREATE TABLE `menu_modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `descricao` varchar(256) NOT NULL,
  `path` varchar(150) NOT NULL,
  `target` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `menu_modulos` */

insert  into `menu_modulos`(`id`,`menu_id`,`descricao`,`path`,`target`) values 
(1,1,'Membros','app/cadastros/membros/index.php','_self'),
(2,1,'Atas','app/cadastros/atas/index.php','_self'),
(3,1,'Dons','app/cadastros/dons/index.php','_self'),
(4,1,'Cargos','app/cadastros/cargos/index.php','_self'),
(5,1,'Departamentos','app/cadastros/departamentos/index.php','_self'),
(6,1,'Locais','app/cadastros/local/index.php','_self'),
(7,1,'Profissões','app/cadastros/profissoes/index.php','_self'),
(8,1,'Fornecedores','app/cadastros/fornecedores/index.php','_self'),
(9,1,'Tipo Fornecedores','app/cadastros/tipo_fornecedores/index.php','_self'),
(10,1,'Pastores','app/cadastros/pastores/index.php','_self'),
(12,2,'Membros Quórum','app/relatorios/membros_quorum/index.php','_blank'),
(13,2,'Membros Menores de 18 Anos','app/relatorios/membros_menores/index.php','_self'),
(14,2,'Membros Aniversário de Casamento','app/relatorios/membros_matrimonios/index.php','_self'),
(15,2,'Membros Aniversariantes','app/relatorios/membros_aniversariantes/index.php','_self'),
(16,2,'Membros Inconsistências','app/relatorios/membros_inconsistencias/index.php','_blank'),
(17,1,'Tipo Produtos','app/cadastros/tipo_produtos/index.php','_self'),
(18,1,'Produtos','app/cadastros/produtos/index.php','_self'),
(19,2,'Membros Geral','app/relatorios/membros/index.php','_self'),
(20,1,'Tipos Ata','app/cadastros/ata_tipos/index.php','_self'),
(21,1,'Tipos Documento','app/cadastros/documento_tipos/index.php','_self'),
(22,1,'Documentos','app/cadastros/documentos/index.php','_self'),
(23,1,'Igrejas','app/cadastros/empresas/index.php','_self'),
(25,3,'Bancos','app/cadastros/bancos/index.php','_self'),
(26,3,'Contas Financeiras','app/cadastros/contas_financeira','_self');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
