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

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `situacao` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `solicitante_id` int(11) unsigned NOT NULL,
  `data` date NOT NULL,
  `justificativa` text COLLATE utf8_unicode_ci NOT NULL,
  `autorizador_id` int(11) unsigned DEFAULT NULL,
  `data_autorizacao` date DEFAULT NULL,
  `tesoureiro_id` int(11) unsigned DEFAULT NULL,
  `data_tesouraria` date DEFAULT NULL,
  `valor_tesouraria` decimal(10,2) DEFAULT NULL,
  `data_nota` date DEFAULT NULL,
  `valor_nota` decimal(10,2) DEFAULT NULL,
  `numero_nota` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacao` text COLLATE utf8_unicode_ci,
  `path_nota` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `compras` */

/*Table structure for table `compras_itens` */

DROP TABLE IF EXISTS `compras_itens`;

CREATE TABLE `compras_itens` (
  `compras_id` int(10) unsigned NOT NULL,
  `produtos_id` int(10) unsigned NOT NULL,
  `quantidade` decimal(10,2) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`compras_id`,`produtos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `compras_itens` */

/*Table structure for table `compras_orcamentos` */

DROP TABLE IF EXISTS `compras_orcamentos`;

CREATE TABLE `compras_orcamentos` (
  `fornecedores_id` int(11) unsigned NOT NULL,
  `compras_id` int(11) unsigned NOT NULL,
  `orcamento_path` varchar(800) NOT NULL,
  `data_orcamento` date DEFAULT NULL,
  `aprovado` char(1) DEFAULT NULL COMMENT '(S)im ou (N)ão',
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`fornecedores_id`,`compras_id`),
  KEY `fk_assoc_compras_fornecedores_has_compras` (`compras_id`),
  CONSTRAINT `fk_assoc_compras_fornecedores_has_compras` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_assoc_compras_fornecedores_has_fornecedores` FOREIGN KEY (`fornecedores_id`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `compras_orcamentos` */

/* Procedure structure for procedure `compra_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `compra_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `compra_seleciona`(
	vid INT(11) unsigned
)
BEGIN
	SELECT C.*, S.nome solicitante_nome, A.nome autorizador_nome, T.nome tesoureiro_nome, CO.fornecedores_id fornecedor
	FROM compras C
  inner JOIN membros S
    ON C.solicitante_id = S.id
  LEFT JOIN membros A
    ON C.autorizador_id = A.id  
  LEFT JOIN membros T
    ON T.tesoureiro_id = T.id      
  left join compras_orcamentos CO
		on C.id = CO.compras_id
	 and CO.aprovado = 'S'
	WHERE C.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `compras_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `compras_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_seleciona`(
	vempresa INT(11),
	vsolicitante int(11) unsigned,
	vdata_ini date,
	vdata_fim DATE
)
BEGIN
	SELECT C.*, S.nome solicitante_nome, A.nome autorizador_nome, T.nome tesoureiro_nome
	FROM compras C
  inner JOIN membros S
    ON C.solicitante_id = S.id
  LEFT JOIN membros A
    ON C.autorizador_id = A.id  
  LEFT JOIN membros T
    ON T.tesoureiro_id = T.id      
	WHERE C.empresa_id = vempresa
		and C.data between vdata_ini and vdata_fim
		AND C.solicitante_id = vsolicitante;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
