/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.26-0ubuntu0.16.04.1 : Database - igreja_hom
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

/*Table structure for table `assoc_contas_categorias_financeira` */

DROP TABLE IF EXISTS `assoc_contas_categorias_financeira`;

CREATE TABLE `assoc_contas_categorias_financeira` (
  `contas_financeira_id` int(10) unsigned NOT NULL,
  `categorias_financeira_id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`contas_financeira_id`,`categorias_financeira_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `bancos` */

DROP TABLE IF EXISTS `bancos`;

CREATE TABLE `bancos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8 COMMENT='C: Conta corrente\r\nP: Conta poupança\r\nI: Investimento';

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

/*Table structure for table `centro_custo` */

DROP TABLE IF EXISTS `centro_custo`;

CREATE TABLE `centro_custo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) CHARACTER SET latin1 NOT NULL,
  `principal` char(1) DEFAULT NULL COMMENT '(S)im para centro de custo principal',
  `ativo` char(1) DEFAULT NULL,
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `contas_financeira` */

DROP TABLE IF EXISTS `contas_financeira`;

CREATE TABLE `contas_financeira` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `banco_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?bancos:id;nome',
  `agencia` varchar(10) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `variacao` varchar(5) DEFAULT NULL,
  `tipo_conta` char(1) NOT NULL COMMENT 'combo?Corrente;Aplicação',
  `tipo_aplicacao` char(1) DEFAULT NULL COMMENT 'combo?Própria;Transitória',
  `ativo` char(1) DEFAULT 'S',
  `saldo_inicial` decimal(10,2) DEFAULT '0.00',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_contas_has_banco` (`banco_id`),
  CONSTRAINT `fk_contas_has_banco` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Table structure for table `grupos_financeiro` */

DROP TABLE IF EXISTS `grupos_financeiro`;

CREATE TABLE `grupos_financeiro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `tipo` char(1) DEFAULT NULL COMMENT 'combo?Despesa;Receita',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `log_movimentacao_financeira` */

DROP TABLE IF EXISTS `log_movimentacao_financeira`;

CREATE TABLE `log_movimentacao_financeira` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `movimentacao_financeira_id` int(11) unsigned DEFAULT NULL,
  `valor_new` text,
  `valor_old` text,
  `cancelado` char(1) DEFAULT NULL,
  `user_id_cancela` int(11) DEFAULT NULL,
  `justifica_cancela` text,
  `mov_empresa_id` int(11) DEFAULT NULL,
  `mov_user_id` int(11) DEFAULT NULL,
  `mov_created` datetime DEFAULT NULL,
  `mov_modified` datetime DEFAULT NULL,
  `acao` char(1) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;

/*Table structure for table `mov_fin_arquivos` */

DROP TABLE IF EXISTS `mov_fin_arquivos`;

CREATE TABLE `mov_fin_arquivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `movimentacao_financeira_id` int(11) unsigned NOT NULL,
  `path` varchar(200) NOT NULL,
  `nome` varchar(115) NOT NULL,
  `dataupload` date NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_mov_fin_arquivos_has_movimentacao_financeira_idx` (`movimentacao_financeira_id`),
  CONSTRAINT `fk_mov_finac_id_mov_financ_arq` FOREIGN KEY (`movimentacao_financeira_id`) REFERENCES `movimentacao_financeira` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tabela Responsavel por armazenar os arquivos dos lançamentos diários (movimentação financeira)';

/*Table structure for table `movimentacao_financeira` */

DROP TABLE IF EXISTS `movimentacao_financeira`;

CREATE TABLE `movimentacao_financeira` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` char(1) NOT NULL COMMENT '(E)ntrada/Receita ou (S)aída/Despesa',
  `data` date NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `documento` varchar(20) DEFAULT NULL COMMENT 'Campo para gravar o número do recibo, Nota Fiscal, etc.',
  `categoria_financeira_id` int(10) unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `centro_custo_id` int(11) unsigned NOT NULL,
  `membro_id` int(11) unsigned DEFAULT NULL,
  `cancelado` char(1) DEFAULT NULL COMMENT 'Indica se o lançamento foi cancelado pelo responsável (S)im ou (N)ão',
  `user_id_cancela` int(11) DEFAULT NULL,
  `justifica_cancela` text,
  `contas_financeira_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;

/*Table structure for table `movimentacao_saldo` */

DROP TABLE IF EXISTS `movimentacao_saldo`;

CREATE TABLE `movimentacao_saldo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `conta_financ_id` int(10) unsigned DEFAULT NULL,
  `contas_financ_origem_id` int(10) unsigned DEFAULT NULL,
  `contas_financ_destino_id` int(10) unsigned DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `cancelado` char(1) DEFAULT 'N',
  `user_id_cancela` int(11) DEFAULT NULL,
  `justificativa_cancela` varchar(500) DEFAULT NULL,
  `movimentacao_financeira_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mov_saldo_contas_financ_destino` (`contas_financ_destino_id`),
  KEY `fk_mov_saldo_contas_financ_origem` (`contas_financ_origem_id`),
  CONSTRAINT `fk_mov_saldo_contas_financ_destino` FOREIGN KEY (`contas_financ_destino_id`) REFERENCES `contas_financeira` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mov_saldo_contas_financ_origem` FOREIGN KEY (`contas_financ_origem_id`) REFERENCES `contas_financeira` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;

/*Table structure for table `orcamento` */

DROP TABLE IF EXISTS `orcamento`;

CREATE TABLE `orcamento` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ano` char(4) NOT NULL,
  `mes` char(2) NOT NULL,
  `categoria_id` int(10) unsigned NOT NULL,
  `valor_previsto` decimal(10,2) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_ix_emp_ano_mes_cat` (`empresa_id`,`ano`,`mes`,`categoria_id`),
  KEY `fk_orcamento_has_categoria_financeira` (`categoria_id`),
  CONSTRAINT `fk_orcamento_has_categoria_financeira` FOREIGN KEY (`categoria_id`) REFERENCES `igreja`.`categorias_financeira` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
