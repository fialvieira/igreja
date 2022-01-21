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

/*Table structure for table `documento_tipos` */

DROP TABLE IF EXISTS `documento_tipos`;

CREATE TABLE `documento_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `path_modelo` varchar(200) DEFAULT NULL,
  `ativo` char(1) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Tipos de documento';

/*Data for the table `documento_tipos` */

insert  into `documento_tipos`(`id`,`descricao`,`path_modelo`,`ativo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Carta 1º Aviso Desligamento','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_1_aviso_desligamento.docx','S',1,7,'2018-03-20 22:49:03','2018-03-26 21:45:38'),
(2,'Carta 2º Aviso Desligamento','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_2_aviso_desligamento.docx','S',1,9,'2018-03-23 17:57:42','2018-03-23 17:57:42'),
(3,'Carta Desligamento Pedido Membro','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_desligamento_pedido_membro.docx','S',1,9,'2018-03-23 17:58:05','2018-03-23 17:58:05'),
(4,'Carta Referências Diácono','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_referencias_diacono.docx','S',1,9,'2018-03-23 17:58:33','2018-03-23 17:58:33'),
(5,'Carta Solicitação Entrada Membro','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_solicitacao_entrada_membro.docx','S',1,9,'2018-03-23 17:58:57','2018-03-23 17:58:57'),
(6,'Carta Transferência Saída Membro','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/carta_transferencia_saida_membro.docx','S',1,9,'2018-03-23 17:59:30','2018-03-23 17:59:30'),
(7,'Envelope','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/envelope.docx','S',1,9,'2018-03-23 17:59:42','2018-03-23 17:59:42'),
(8,'Termo de Posse Cabrália Paulista','/var/www/hom.aiftech.com.br/public_html/projeto_igreja/aiftech/arquivos/empresa_id_1/documentos/modelos/termo_posse_pastor_cabralia.docx','S',1,7,'2018-03-27 08:13:16','2018-04-02 21:46:45');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
