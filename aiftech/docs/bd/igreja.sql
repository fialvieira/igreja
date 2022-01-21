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

/*Table structure for table `assoc_departamentos_cargos` */

DROP TABLE IF EXISTS `assoc_departamentos_cargos`;

CREATE TABLE `assoc_departamentos_cargos` (
  `departamento_id` int(11) unsigned NOT NULL,
  `cargo_id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) unsigned DEFAULT NULL,
  `ativo` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`departamento_id`,`cargo_id`),
  KEY `fk_cargo` (`cargo_id`),
  CONSTRAINT `fk_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `assoc_empresas_pastores` */

DROP TABLE IF EXISTS `assoc_empresas_pastores`;

CREATE TABLE `assoc_empresas_pastores` (
  `empresa_id` int(11) NOT NULL,
  `pastor_id` int(11) unsigned NOT NULL,
  `dt_entrada` date DEFAULT NULL,
  `dt_saida` date DEFAULT NULL,
  `ata_entrada` int(11) unsigned DEFAULT NULL,
  `ata_saida` int(11) unsigned DEFAULT NULL,
  `categoria` char(1) DEFAULT NULL COMMENT 'Indica de pastor é titular, auxiliar ou foi desligado na igreja',
  `user_id` varchar(25) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`empresa_id`,`pastor_id`),
  KEY `fk_churchs_has_pastores_pastores_idx` (`pastor_id`),
  KEY `fk_churchs_has_pastores_atas_entrada_idx` (`ata_entrada`),
  KEY `fk_churchs_has_pastores_atas_saida_idx` (`ata_saida`),
  KEY `fk_churchs_has_pastores_churchs_idx` (`empresa_id`),
  KEY `fk_churchs_has_pastores_idx` (`pastor_id`,`empresa_id`),
  CONSTRAINT `fk_churchs_has_pastores_atas_entrada` FOREIGN KEY (`ata_entrada`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_churchs_has_pastores_atas_saida` FOREIGN KEY (`ata_saida`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_churchs_has_pastores_churchs` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_churchs_has_pastores_pastores` FOREIGN KEY (`pastor_id`) REFERENCES `pastores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `assoc_empresas_users` */

DROP TABLE IF EXISTS `assoc_empresas_users`;

CREATE TABLE `assoc_empresas_users` (
  `empresa_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`empresa_id`,`users_id`),
  KEY `fk_churchs_has_users_users1_idx` (`users_id`),
  KEY `fk_churchs_has_users_churchs_idx` (`empresa_id`),
  CONSTRAINT `fk_churchs_has_users_churchs` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_churchs_has_users_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `assoc_membros_cargos` */

DROP TABLE IF EXISTS `assoc_membros_cargos`;

CREATE TABLE `assoc_membros_cargos` (
  `membro_id` int(10) unsigned NOT NULL,
  `cargo_id` int(10) unsigned NOT NULL,
  `ativo` char(1) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`membro_id`,`cargo_id`),
  KEY `IX_cargo_id_membro_id` (`cargo_id`,`membro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela associativa entre membros e cargos';

/*Table structure for table `assoc_membros_empresas` */

DROP TABLE IF EXISTS `assoc_membros_empresas`;

CREATE TABLE `assoc_membros_empresas` (
  `membro_id` int(11) unsigned NOT NULL,
  `empresa_ant_id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`membro_id`,`empresa_ant_id`,`empresa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ata_arquivos` */

DROP TABLE IF EXISTS `ata_arquivos`;

CREATE TABLE `ata_arquivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ata_id` int(11) unsigned NOT NULL COMMENT 'relaciona?atas:id;num',
  `path` varchar(200) NOT NULL,
  `nome` varchar(115) NOT NULL,
  `dataupload` date DEFAULT NULL,
  `ata_digit` char(1) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_ata_arquivos_has_atas_idx` (`ata_id`),
  CONSTRAINT `fk_ata_arquivos_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Arquivos de Atas*Tabela Responsavel por armazenar os arquivos das atas e rela';

/*Table structure for table `ata_assuntos` */

DROP TABLE IF EXISTS `ata_assuntos`;

CREATE TABLE `ata_assuntos` (
  `ata_id` int(11) unsigned NOT NULL,
  `id` int(11) unsigned NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `texto` text NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`ata_id`,`id`),
  KEY `fk_ata_assuntos_has_atas_idx` (`ata_id`),
  KEY `ata_assuntos_ix` (`id`,`ata_id`),
  CONSTRAINT `fk_ata_assuntos_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Assuntos de Atas*Tabela Responsavel por armazenar os assunto contidos nas atas';

/*Table structure for table `ata_participantes` */

DROP TABLE IF EXISTS `ata_participantes`;

CREATE TABLE `ata_participantes` (
  `ata_id` int(11) unsigned NOT NULL,
  `membro_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ata_id`,`membro_id`),
  KEY `fk_atas_participantes_has_ata` (`ata_id`),
  KEY `ix_ata_participantes` (`membro_id`,`ata_id`),
  CONSTRAINT `fk_atas_participantes_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_atas_participantes_has_membro` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ata_tipos` */

DROP TABLE IF EXISTS `ata_tipos`;

CREATE TABLE `ata_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `ativo` char(1) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Tipos de Ata';

/*Table structure for table `atas` */

DROP TABLE IF EXISTS `atas`;

CREATE TABLE `atas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` bigint(20) unsigned NOT NULL,
  `data` date DEFAULT NULL,
  `tipo_ata` int(11) unsigned NOT NULL,
  `presidencia` int(10) unsigned DEFAULT NULL,
  `tx_abertura` text,
  `tx_corpo` text NOT NULL,
  `tx_encerramento` text,
  `secretario` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  `ata_ft` text NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `presidencia` (`presidencia`),
  KEY `secretario` (`secretario`),
  FULLTEXT KEY `Fultext_ix` (`ata_ft`),
  CONSTRAINT `fk_atas_membros_presidencia` FOREIGN KEY (`presidencia`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_atas_membros_secretario` FOREIGN KEY (`secretario`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Atas*Cadastro de Todas as Atas do Sistema';

/*Table structure for table `autores` */

DROP TABLE IF EXISTS `autores`;

CREATE TABLE `autores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Autores*Cadastro de autores da biblioteca';

/*Table structure for table `bancos` */

DROP TABLE IF EXISTS `bancos`;

CREATE TABLE `bancos` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `número` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bens` */

DROP TABLE IF EXISTS `bens`;

CREATE TABLE `bens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `identificacao` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `num_serie` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `num_ativo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `garantia` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `observacao` text CHARACTER SET latin1,
  `data_compra` date DEFAULT NULL,
  `valor_unitario` decimal(18,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `departamento_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?departamentos:id;nome',
  `congregacao_id` int(11) unsigned DEFAULT NULL,
  `membro_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?membros:id;nome',
  `tipo_bem_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?tipo_bens:id;nome',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_bens_has_departamentos_idx` (`departamento_id`),
  KEY `fk_bens_has_membros` (`membro_id`),
  KEY `fk_bens_has_tipo_bens` (`tipo_bem_id`),
  CONSTRAINT `fk_bens_has_departamentos` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bens_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bens_has_tipo_bens` FOREIGN KEY (`tipo_bem_id`) REFERENCES `tipo_bens` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bens*Cadastro de Bens do sistema.';

/*Table structure for table `calendarios` */

DROP TABLE IF EXISTS `calendarios`;

CREATE TABLE `calendarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datainicio` datetime DEFAULT NULL,
  `assunto` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `datafim` datetime DEFAULT NULL,
  `descricao` text CHARACTER SET latin1,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `diatodo` int(11) DEFAULT NULL,
  `cor` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Calendarios*Tabela para guardar os eventos da igreja';

/*Table structure for table `cargos` */

DROP TABLE IF EXISTS `cargos`;

CREATE TABLE `cargos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(135) DEFAULT NULL,
  `descricao` text,
  `abreviacao` varchar(90) DEFAULT NULL,
  `tipo` char(3) DEFAULT NULL,
  `tipo_comissao` char(3) DEFAULT NULL,
  `ordem` tinyint(4) DEFAULT NULL,
  `preencher` varchar(6) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Categorias*Cadastro de editoras da biblioteca';

/*Table structure for table `categorias_financeira` */

DROP TABLE IF EXISTS `categorias_financeira`;

CREATE TABLE `categorias_financeira` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  `grupo_financeiro_id` int(10) unsigned NOT NULL COMMENT 'relaciona?grupos_financeiro:id;nome',
  PRIMARY KEY (`id`),
  KEY `fk_categoria_has_grupos` (`grupo_financeiro_id`),
  CONSTRAINT `fk_categoria_has_grupos` FOREIGN KEY (`grupo_financeiro_id`) REFERENCES `categorias_financeira` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `contas_financeira` */

DROP TABLE IF EXISTS `contas_financeira`;

CREATE TABLE `contas_financeira` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `banco_id` tinyint(4) unsigned DEFAULT NULL COMMENT 'relaciona?bancos:id;nome',
  `agencia` varchar(10) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `variacao` varchar(5) DEFAULT NULL,
  `tipo_conta` char(1) NOT NULL COMMENT 'combo?Corrente;Aplicação',
  `tipo_aplicacao` char(1) DEFAULT NULL COMMENT 'combo?Própria;Transitória',
  `empresa_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_contas_has_banco` (`banco_id`),
  CONSTRAINT `fk_contas_has_banco` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `contatos` */

DROP TABLE IF EXISTS `contatos`;

CREATE TABLE `contatos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `congregacao_id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contatos*Armazena contatos das congregações';

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `abreviacao` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `eleicao` char(1) DEFAULT NULL,
  `interesse` char(1) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Departamentos*Cadastro Departamentos';

/*Table structure for table `dons` */

DROP TABLE IF EXISTS `dons`;

CREATE TABLE `dons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `observacoes` text CHARACTER SET latin1,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Dons*Cadastro de Dons';

/*Table structure for table `editoras` */

DROP TABLE IF EXISTS `editoras`;

CREATE TABLE `editoras` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Editoras*Cadastro de categorias da biblioteca';

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enderecos_id` int(11) unsigned DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL COMMENT '(S)im, (N)ão.',
  `cliente` char(1) DEFAULT NULL COMMENT '(S)im, (N)ão.',
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `cnpj` varchar(14) CHARACTER SET latin1 DEFAULT NULL,
  `telefone` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `numero` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `complemento` varchar(70) DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `matriz_id` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `subdomain` varchar(15) CHARACTER SET latin1 DEFAULT NULL COMMENT 'oculto',
  `whatsapp` char(1) DEFAULT 'S',
  `celular` varchar(45) DEFAULT NULL,
  `abreviacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empresas_enderecos1_idx` (`enderecos_id`),
  CONSTRAINT `fk_empresas_enderecos1` FOREIGN KEY (`enderecos_id`) REFERENCES `enderecos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COMMENT='Igrejas*Cadastro das igrejas no sistema. ';

/*Table structure for table `enderecos` */

DROP TABLE IF EXISTS `enderecos`;

CREATE TABLE `enderecos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cep` varchar(10) CHARACTER SET latin1 NOT NULL,
  `logradouro` varchar(70) CHARACTER SET latin1 NOT NULL,
  `bairro` varchar(45) CHARACTER SET latin1 NOT NULL,
  `localidade` varchar(100) NOT NULL COMMENT 'Cidade',
  `estado_id` int(11) unsigned NOT NULL COMMENT 'relaciona?estados:id;sigla',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_enderecos_has_estados` (`estado_id`),
  CONSTRAINT `fk_enderecos_has_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Endereços*Cadastro Endereços';

/*Table structure for table `escolaridades` */

DROP TABLE IF EXISTS `escolaridades`;

CREATE TABLE `escolaridades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '	',
  `descricao` varchar(100) CHARACTER SET latin1 NOT NULL,
  `obs` text CHARACTER SET latin1,
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Escolaridades*Cadastro Escolaridade';

/*Table structure for table `estados` */

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sigla` varchar(2) NOT NULL,
  `codibge` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='Estados*Tabela com código, sigla e nome dos estados do Brasil';

/*Table structure for table `fornecedores` */

DROP TABLE IF EXISTS `fornecedores`;

CREATE TABLE `fornecedores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_fantasia` varchar(150) NOT NULL,
  `razao_social` varchar(150) NOT NULL,
  `cnpj` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `telefone2` varchar(11) DEFAULT NULL,
  `endereco_id` int(11) unsigned DEFAULT NULL,
  `enderecos_numero` varchar(45) DEFAULT NULL,
  `enderecos_complemento` varchar(256) DEFAULT NULL,
  `tipo` int(10) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `empresa_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_fornecedores_has_enderecos` (`endereco_id`),
  CONSTRAINT `fk_fornecedores_has_enderecos` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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

/*Table structure for table `itens` */

DROP TABLE IF EXISTS `itens`;

CREATE TABLE `itens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `titulo` varchar(150) CHARACTER SET latin1 NOT NULL,
  `foto` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `preco` decimal(18,2) DEFAULT NULL,
  `comentarios` text CHARACTER SET latin1,
  `estoque` int(11) DEFAULT NULL,
  `autor_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?autores:id;nome',
  `categoria_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?categorias:id;nome',
  `editora_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?editoras:id;nome',
  `tipo_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?tipo_biblioteca:id;nome',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_itens_has_autores_idx` (`autor_id`),
  KEY `fk_itens_has_categorias_idx` (`categoria_id`),
  KEY `fk_itens_has_editoras_idx` (`editora_id`),
  KEY `fk_itens_has_tipo_biblioteca` (`tipo_id`),
  CONSTRAINT `fk_itens_has_autores` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_itens_has_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_itens_has_editoras` FOREIGN KEY (`editora_id`) REFERENCES `editoras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_itens_has_tipo_biblioteca` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_biblioteca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Itens*Cadastro de itens da biblioteca (livros, cds, dvds, etc)';

/*Table structure for table `local` */

DROP TABLE IF EXISTS `local`;

CREATE TABLE `local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `sede` char(1) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `ativo` char(1) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  UNIQUE KEY `LOC_NOM` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Table structure for table `membros` */

DROP TABLE IF EXISTS `membros`;

CREATE TABLE `membros` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `frequencia_id` int(11) DEFAULT NULL,
  `nome` varchar(100) CHARACTER SET latin1 NOT NULL,
  `sexo` char(1) DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `naturalidade` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `estado_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?estados:id;sigla',
  `estadocivil` tinyint(10) unsigned DEFAULT NULL,
  `latitude` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `rg` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `orgao_emissor` varchar(20) DEFAULT NULL,
  `data_expedicao` date DEFAULT NULL,
  `cpf` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `fone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `cel` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `escolaridade_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?escolaridades:id;descricao',
  `profissao_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?profissoes:id;nome',
  `empresa` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `databatismo` date DEFAULT NULL,
  `igrejas_id` int(11) DEFAULT NULL,
  `pastorbatismo` int(11) DEFAULT NULL,
  `ultimaigreja` int(11) DEFAULT NULL,
  `datamembro` date DEFAULT NULL,
  `cargo_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `enderecos_id` int(11) unsigned DEFAULT NULL,
  `enderecos_numero` varchar(45) DEFAULT NULL,
  `enderecos_complemento` varchar(256) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  `tipo` char(1) CHARACTER SET latin1 DEFAULT NULL COMMENT 'combo?Membro;Visitante',
  `membros_ft` text COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_membros_has_estados` (`estado_id`),
  KEY `fk_membros_has_escolaridades` (`escolaridade_id`),
  KEY `fk_membros_has_profissoes` (`profissao_id`),
  KEY `fk_membros_enderecos1_idx` (`enderecos_id`),
  FULLTEXT KEY `membros_ft` (`membros_ft`),
  CONSTRAINT `fk_membros_enderecos1` FOREIGN KEY (`enderecos_id`) REFERENCES `enderecos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_membros_has_escolaridades` FOREIGN KEY (`escolaridade_id`) REFERENCES `escolaridades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_membros_has_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_membros_has_profissoes` FOREIGN KEY (`profissao_id`) REFERENCES `profissoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2745 DEFAULT CHARSET=utf8 COMMENT='Membros*Cadastro de membros';

/*Table structure for table `membros_frequencia` */

DROP TABLE IF EXISTS `membros_frequencia`;

CREATE TABLE `membros_frequencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequencia` varchar(255) NOT NULL,
  `status` char(1) NOT NULL,
  `quorum` char(1) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Table structure for table `movimentacao_atas` */

DROP TABLE IF EXISTS `movimentacao_atas`;

CREATE TABLE `movimentacao_atas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cargo_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?cargos:id;nome',
  `membro_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?membros:id;nome',
  `ata_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?atas:id;num',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_movimentacaoatas_has_cargos` (`cargo_id`),
  KEY `fk_movimentacaoatas_has_membros` (`membro_id`),
  KEY `fk_movimentacaoatas_has_atas` (`ata_id`),
  CONSTRAINT `fk_movimentacaoatas_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimentacaoatas_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Armazena a movimentação de cargos de acordo com as atas lanç';

/*Table structure for table `movimentacao_bens` */

DROP TABLE IF EXISTS `movimentacao_bens`;

CREATE TABLE `movimentacao_bens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `motivo` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `bem_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?bens:id;nome',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_movimentacao_bens_has_bens_idx` (`bem_id`),
  CONSTRAINT `fk_movimentacao_bens_has_bens` FOREIGN KEY (`bem_id`) REFERENCES `movimentacao_bens` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Movimentação de Bens*Tabela que armazena o histórico de movimentação dos bens';

/*Table structure for table `movimentacao_itens` */

DROP TABLE IF EXISTS `movimentacao_itens`;

CREATE TABLE `movimentacao_itens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `quantidade` int(11) DEFAULT NULL,
  `devolvido` int(11) NOT NULL DEFAULT '0',
  `membro_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?membros:id;nome',
  `item_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?itens:id;titulo',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_movimentacao_itens_has_membros_idx` (`membro_id`),
  KEY `fk_movimentacao_itens_has_itens_idx` (`item_id`),
  CONSTRAINT `fk_movimentacao_itens_has_itens` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimentacao_itens_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Movimentação Itens*Tabela que armazena o histórico de empréstimo dos itens da biblioteca';

/*Table structure for table `parametros_sistema` */

DROP TABLE IF EXISTS `parametros_sistema`;

CREATE TABLE `parametros_sistema` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `idade_quorum` int(3) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `pastores` */

DROP TABLE IF EXISTS `pastores`;

CREATE TABLE `pastores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) NOT NULL,
  `tratamento` varchar(15) DEFAULT NULL,
  `sec_atual` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COMMENT='Pastores*Cadastro de pastor';

/*Table structure for table `pessoa_dons` */

DROP TABLE IF EXISTS `pessoa_dons`;

CREATE TABLE `pessoa_dons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dom_id` int(11) unsigned NOT NULL COMMENT 'relaciona?dons:id;nome',
  `membro_id` int(11) unsigned NOT NULL COMMENT 'relaciona?membros:id;nome',
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_dons_has_membros` (`membro_id`),
  KEY `fk_pessoa_dons_has_dons` (`dom_id`),
  CONSTRAINT `fk_pessoa_dons_has_dons` FOREIGN KEY (`dom_id`) REFERENCES `dons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_dons_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `profissoes` */

DROP TABLE IF EXISTS `profissoes`;

CREATE TABLE `profissoes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Profissões*Cadastro Profissão membros';

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
  CONSTRAINT `fk_relacionamentos_has_tiporelacionamentos` FOREIGN KEY (`tiporelacionamento_id`) REFERENCES `tiporelacionamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relacionamentos*Cadastros do relacionamentos do sistema. guarda informações ';

/*Table structure for table `representante` */

DROP TABLE IF EXISTS `representante`;

CREATE TABLE `representante` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `email` varchar(150) CHARACTER SET latin1 NOT NULL,
  `idade` int(11) NOT NULL,
  `ddd` int(11) NOT NULL,
  `telefone` int(11) NOT NULL,
  `tipo_telefone` int(11) NOT NULL,
  `cidade` varchar(100) CHARACTER SET latin1 NOT NULL,
  `estado` varchar(2) CHARACTER SET latin1 NOT NULL,
  `classificacao` int(11) NOT NULL,
  `infoad` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Representante*';

/*Table structure for table `tabelas_auto` */

DROP TABLE IF EXISTS `tabelas_auto`;

CREATE TABLE `tabelas_auto` (
  `codigo` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tabela` varchar(50) NOT NULL,
  `menu` varchar(30) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `perfil` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`codigo`,`tabela`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `tipo_bens` */

DROP TABLE IF EXISTS `tipo_bens`;

CREATE TABLE `tipo_bens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1,
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipo Bens*Cadastro Tipo Bem';

/*Table structure for table `tipo_biblioteca` */

DROP TABLE IF EXISTS `tipo_biblioteca`;

CREATE TABLE `tipo_biblioteca` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Tipo Biblioteca*Cadastro de tipos da biblioteca';

/*Table structure for table `tipo_fornecedores` */

DROP TABLE IF EXISTS `tipo_fornecedores`;

CREATE TABLE `tipo_fornecedores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `tiporelacionamentos` */

DROP TABLE IF EXISTS `tiporelacionamentos`;

CREATE TABLE `tiporelacionamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET latin1 NOT NULL,
  `obs` text CHARACTER SET latin1,
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime NOT NULL COMMENT 'oculto',
  `modified` datetime NOT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipo Relacionamentos*Cadastro de Tipo de Relacionamento. Responsável por armazena';

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) DEFAULT NULL,
  `username` varchar(45) CHARACTER SET latin1 NOT NULL,
  `senha` char(64) CHARACTER SET latin1 NOT NULL,
  `nome` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `celular` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `cpf` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `perfil` tinyint(4) NOT NULL DEFAULT '6',
  `ativo` char(1) DEFAULT 'S',
  `hash_id` char(64) DEFAULT NULL,
  `users_ft` text,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `users_ft` (`users_ft`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Todos os usuários do Sistema.';

/* Procedure structure for procedure `assoc_empresa_pastor_ins_upd` */

/*!50003 DROP PROCEDURE IF EXISTS  `assoc_empresa_pastor_ins_upd` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `assoc_empresa_pastor_ins_upd`(
	IN `vempresa_id` int(11),
	IN `vpastor_id` INT(11) UNSIGNED,
	IN `vdt_entrada` DATE,
	IN `vata_entrada` int(11) unsigned,
	IN `vdt_saida` DATE,
	IN `vata_saida` INT(11) UNSIGNED,
	IN `vcategoria` char(1),
	IN `vuser_id` INT(11) UNSIGNED,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	set @rec = 0;
	select count(*) into @rec
	from assoc_empresas_pastores
	where empresa_id = vempresa_id
	  and pastor_id = vpastor_id;
	 
	if @rec = 0 then
		INSERT INTO assoc_empresas_pastores
		(empresa_id, pastor_id, dt_entrada, dt_saida, ata_entrada, ata_saida, categoria, user_id, created)
		VALUES
		(vempresa_id, vpastor_id, vdt_entrada, vdt_saida, vata_entrada, vata_saida, vcategoria, CONCAT(vuser_id,' - ',vempresa_id), vcreated);
	else
		UPDATE assoc_empresas_pastores
		SET dt_entrada = vdt_entrada,
			ata_entrada = vata_entrada,
			dt_saida = vdt_saida,
			ata_saida = vata_saida,
			categoria = vcategoria,
			user_id = CONCAT(vempresa_id,' - ',vuser_id),
			modified = vmodified
		WHERE empresa_id = vempresa_id
		  AND pastor_id = vpastor_id;
	end if;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `atas_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `atas_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_seleciona`(
	IN `vempresa` INT(11)
)
BEGIN
	SELECT A.*, T.descricao tipo_desc
	FROM atas A
  LEFT JOIN ata_tipos T
    ON A.tipo_ata = T.id
  WHERE A.empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vdata` DATE,
	IN `vtipo_ata` INT,
	IN `vpresidencia` INT,
	IN `vtx_abertura` TEXT,
	IN `vtx_corpo` TEXT,
	IN `vtx_encerramento` TEXT,
	IN `vsecretario` INT,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
,
	IN `vata_ft` TEXT
)
BEGIN
	UPDATE atas
	SET
	data = vdata,
  tipo_ata = vtipo_ata,
  presidencia = vpresidencia,
  tx_abertura = vtx_abertura,
  tx_corpo = vtx_corpo,
  tx_encerramento = vtx_encerramento,
  secretario = vsecretario,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified,
  ata_ft = vata_ft
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivos_seleciona`(
	IN `vempresa` INT,
	IN `vata` INT(11)
,
	IN `vata_digit` CHAR(1)
)
BEGIN
	SELECT AA.*
	FROM ata_arquivos AA
  WHERE AA.empresa_id = vempresa
    AND AA.ata_id = vata
    AND IFNULL(AA.ata_digit,'') = CASE WHEN vata_digit = 'T' THEN IFNULL(AA.ata_digit,'')
                                       WHEN vata_digit = 'N' THEN '' 
                                       ELSE vata_digit
                                  END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_exclui`(
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	DELETE 
  FROM ata_arquivos
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_insere`(
	IN `vata_id` INT(11) UNSIGNED,
	IN `vpath` VARCHAR(200),
	IN `vnome` VARCHAR(115),
	IN `vdataupload` DATE,
	IN `vata_digit` CHAR(1),
	IN `vuser_id` INT(11) UNSIGNED,
	IN `vempresa_id` INT(11) UNSIGNED,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO ata_arquivos
	(ata_id, path, nome, dataupload, ata_digit, user_id, empresa_id, created, modified)
	VALUES
	(vata_id, vpath, vnome, vdataupload, vata_digit, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_seleciona`(
	IN `vempresa` INT,
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM ata_arquivos 
	WHERE empresa_id = vempresa
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assuntos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assuntos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assuntos_seleciona`(
	IN `vata` INT
)
BEGIN
  SELECT *
  FROM ata_assuntos
  WHERE ata_id = vata;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_altera`(
	IN `vata_id` INT,
	IN `vid` INT,
	IN `vtitulo` VARCHAR(50),
	IN `vtexto` TEXT,
	IN `vuser_id` INT,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE ata_assuntos
	SET
	titulo = vtitulo,
  texto = vtexto,
	user_id = vuser_id,
	modified = vmodified
	WHERE ata_id = vata_id
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_exclui`(
	IN `vata_id` INT,
	IN `vid` INT
)
BEGIN
  DELETE
  FROM ata_assuntos
  WHERE ata_id = vata_id
    AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_assunto_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_assunto_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_assunto_insere`(
	IN `vata_id` INT,
	IN `vtitulo` VARCHAR(50),
	IN `vtexto` TEXT,
	IN `vuser_id` INT,
	IN `vempresa_id` INT,
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	SET @REC = 0;
  SELECT id INTO @REC
  FROM ata_assuntos
  WHERE ata_id = vata_id 
  ORDER BY id DESC
  LIMIT 1; 
  SET @REC = @REC+1;
	INSERT INTO ata_assuntos
	(ata_id, id, titulo, texto, user_id, empresa_id, created, modified)
	VALUES
	(vata_id, @REC, vtitulo, vtexto, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT @REC id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_insere`(
	IN `vdata` DATE,
	IN `vtipo_ata` INT,
	IN `vpresidencia` INT,
	IN `vtx_abertura` TEXT,
	IN `vtx_corpo` TEXT,
	IN `vtx_encerramento` TEXT,
	IN `vsecretario` INT,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
,
	IN `vata_ft` TEXT
)
BEGIN
	SET @REC = 0;
  SELECT num INTO @REC
  FROM atas
  WHERE empresa_id = vempresa_id
  ORDER BY num DESC
  LIMIT 1; 
  SET @REC = @REC+1;
	INSERT INTO atas
	(num, data, tipo_ata, presidencia, tx_abertura, tx_corpo, tx_encerramento, secretario, user_id, empresa_id, created, modified, ata_ft)
	VALUES
	(@REC, vdata, vtipo_ata, vpresidencia, vtx_abertura, vtx_corpo, vtx_encerramento, vsecretario, vuser_id, vempresa_id, vcreated, vmodified, vata_ft);
	SELECT LAST_INSERT_ID() id, @REC num;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participantes_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participantes_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participantes_seleciona`(
	IN `vata` INT
(11)
)
BEGIN
	SELECT AP.*, M.nome
	FROM ata_participantes AP
  LEFT JOIN membros M
    ON AP.membro_id = M.id
  WHERE AP.ata_id = vata;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_exclui`(
	IN `vata_id` INT(11),
	IN `vmembro_id` INT(11)
)
BEGIN
  DELETE
  FROM ata_participantes
  WHERE ata_id = vata_id
    AND membro_id = vmembro_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_insere`(
	IN `vata_id` INT(11),
	IN `vmembro_id` INT(11)
)
BEGIN
	INSERT INTO ata_participantes
	(ata_id, membro_id)
	VALUES
	(vata_id, vmembro_id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_participante_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_participante_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_participante_seleciona`(
	IN `vata_id` INT(11)
,
	IN `vmembro_id` INT(11)
)
BEGIN
	SELECT AP.*, M.nome
	FROM ata_participantes AP
  LEFT JOIN membros M
    ON AP.membro_id = M.id
	WHERE AP.ata_id = vata_id
    AND AP.membro_id = vmembro_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_seleciona`(
	IN `vid` INT(11) UNSIGNED
)
BEGIN
	SELECT A.*, T.descricao tipo_desc, M1.nome presidencia_nome, M2.nome secretario_nome
	FROM atas A
  LEFT JOIN ata_tipos T
    ON A.tipo_ata = T.id
  LEFT JOIN membros M1
    ON A.presidencia = M1.id  
  LEFT JOIN membros M2
    ON A.secretario = M2.id      
	WHERE A.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipos_seleciona`(
	IN `vativo` CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM ata_tipos T1
	WHERE IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
																	 ELSE vativo
															END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_tipo_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vdescricao` VARCHAR(50),
	IN `vativo` CHAR(1),
	IN `empresa_id` INT,
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE ata_tipos
	SET
	descricao = vdescricao,
	ativo = vativo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipo_insere`(
	IN `vdescricao` VARCHAR(50),
	IN `vativo` CHAR(1),
	IN `vempresa_id` INT,
	IN `vuser_id` INT,
	IN `created` DATETIME,
	IN `modified` DATETIME
)
BEGIN
	INSERT INTO ata_tipos
	(descricao, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vdescricao, 'S', vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_tipo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_tipo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `ata_tipo_seleciona`(
	IN `vid` INT
)
BEGIN
	SELECT *
	FROM ata_tipos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `autores_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `autores_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `autores_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM autores T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `autor_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `autor_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `autor_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE autores
	SET
	nome = vnome,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `autor_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `autor_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `autor_insere`(
	vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO autores
	(nome, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `autor_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `autor_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `autor_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM autores 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `bancos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `bancos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `bancos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM bancos T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `banco_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `banco_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `banco_altera`(
	vid TINYINT(4) UNSIGNED,
        vnome VARCHAR(100),
        vnúmero VARCHAR(5)
)
BEGIN
	UPDATE bancos
	SET
	nome = vnome,
	número = vnúmero
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `banco_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `banco_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `banco_insere`(
	vnome VARCHAR(100),
        vnúmero VARCHAR(5)
)
BEGIN
	INSERT INTO bancos
	(nome, número)
	VALUES
	(vnome, vnúmero);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `banco_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `banco_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `banco_seleciona`(
	vid TINYINT(4) UNSIGNED
)
BEGIN
	SELECT *
	FROM bancos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `bem_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `bem_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `bem_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(100),
        videntificacao VARCHAR(100),
        vnum_serie VARCHAR(100),
        vnum_ativo VARCHAR(100),
        vgarantia VARCHAR(100),
        vdescricao VARCHAR(150),
        vobservacao TEXT,
        vdata_compra DATE,
        vvalor_unitario DECIMAL(18,2),
        vquantidade INT(11),
        vdepartamento_id INT(11) UNSIGNED,
        vcongregacao_id INT(11) UNSIGNED,
        vmembro_id INT(11) UNSIGNED,
        vtipo_bem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE bens
	SET
	nome = vnome,
	identificacao = videntificacao,
	num_serie = vnum_serie,
	num_ativo = vnum_ativo,
	garantia = vgarantia,
	descricao = vdescricao,
	observacao = vobservacao,
	data_compra = vdata_compra,
	valor_unitario = vvalor_unitario,
	quantidade = vquantidade,
	departamento_id = vdepartamento_id,
	congregacao_id = vcongregacao_id,
	membro_id = vmembro_id,
	tipo_bem_id = vtipo_bem_id,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `bem_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `bem_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `bem_insere`(
	vnome VARCHAR(100),
        videntificacao VARCHAR(100),
        vnum_serie VARCHAR(100),
        vnum_ativo VARCHAR(100),
        vgarantia VARCHAR(100),
        vdescricao VARCHAR(150),
        vobservacao TEXT,
        vdata_compra DATE,
        vvalor_unitario DECIMAL(18,2),
        vquantidade INT(11),
        vdepartamento_id INT(11) UNSIGNED,
        vcongregacao_id INT(11) UNSIGNED,
        vmembro_id INT(11) UNSIGNED,
        vtipo_bem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO bens
	(nome, identificacao, num_serie, num_ativo, garantia, descricao, observacao, data_compra, valor_unitario, quantidade, departamento_id, congregacao_id, membro_id, tipo_bem_id, user_id, empresa_id, created, modified)
	VALUES
	(vnome, videntificacao, vnum_serie, vnum_ativo, vgarantia, vdescricao, vobservacao, vdata_compra, vvalor_unitario, vquantidade, vdepartamento_id, vcongregacao_id, vmembro_id, vtipo_bem_id, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `bem_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `bem_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `bem_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM bens 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `bens_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `bens_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `bens_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome departamento_descricao, T3.nome membro_descricao, T4.nome tipobem_descricao
	FROM bens T1
        LEFT JOIN departamentos T2
               ON T1.departamento_id = T2.id
        LEFT JOIN membros T3
               ON T1.membro_id = T3.id
        LEFT JOIN tipo_bens T4
               ON T1.tipo_bem_id = T4.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `calendarios_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `calendarios_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `calendarios_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM calendarios T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `calendario_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `calendario_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `calendario_altera`(
	vid INT(11) UNSIGNED,
        vdatainicio DATETIME,
        vassunto VARCHAR(50),
        vdatafim DATETIME,
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vmodified DATETIME,
        vcreated DATETIME,
        vdiatodo INT(11),
        vcor VARCHAR(45)
)
BEGIN
	UPDATE calendarios
	SET
	datainicio = vdatainicio,
	assunto = vassunto,
	datafim = vdatafim,
	descricao = vdescricao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	modified = vmodified,
	created = vcreated,
	diatodo = vdiatodo,
	cor = vcor
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `calendario_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `calendario_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `calendario_insere`(
	vdatainicio DATETIME,
        vassunto VARCHAR(50),
        vdatafim DATETIME,
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vmodified DATETIME,
        vcreated DATETIME,
        vdiatodo INT(11),
        vcor VARCHAR(45)
)
BEGIN
	INSERT INTO calendarios
	(datainicio, assunto, datafim, descricao, empresa_id, user_id, modified, created, diatodo, cor)
	VALUES
	(vdatainicio, vassunto, vdatafim, vdescricao, vempresa_id, vuser_id, vmodified, vcreated, vdiatodo, vcor);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `calendario_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `calendario_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `calendario_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM calendarios 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargos_seleciona`(
				vativo CHAR(1),
        vempresa INT(11)
)
BEGIN
	SELECT T1.*
	      ,CASE WHEN tipo = 'D' THEN 'Diretoria'
							WHEN tipo = 'M' THEN 'Ministério'
							ELSE ''
				 END tipo_descricao
				,CASE WHEN tipo_comissao = 'E' THEN 'Estatutária'
							WHEN tipo_comissao = 'O' THEN 'Outras'
							ELSE ''
				 END tipo_comissao_descricao
	FROM cargos T1
	WHERE T1.empresa_id = vempresa
		 AND IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
																		ELSE vativo
															 END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_altera`(
				vid INT(11) UNSIGNED,
        vnome VARCHAR(45),
        vdescricao TEXT,
        vabreviacao VARCHAR(30),
        vtipo CHAR(1),
        vtipo_comissao CHAR(1),
        vativo CHAR(1),
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE cargos
	SET
	nome = vnome,
	descricao = vdescricao,
	abreviacao = vabreviacao,
	tipo = vtipo,
	tipo_comissao = vtipo_comissao,
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_insere`(
	vnome 		VARCHAR(45),
        vdescricao 	TEXT,
        vabreviacao 	VARCHAR(30),
        vtipo 		CHAR(1),
        vtipo_comissao 	CHAR(1),
        vativo 		CHAR(1),
        vempresa_id	INT(11) UNSIGNED,
        vuser_id 	INT(11) UNSIGNED,
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	INSERT INTO cargos
	(nome, descricao, abreviacao, tipo, tipo_comissao, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vabreviacao, vtipo, vtipo_comissao, vativo, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_seleciona`(
				vid INT(11) UNSIGNED,
        vempresa INT(11)
)
BEGIN
	SELECT *
	FROM cargos 
	WHERE empresa_id = vempresa 
	  AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categorias_financeira_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `categorias_financeira_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_altera`(
	vid INT(10) UNSIGNED,
        vnome VARCHAR(100),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME,
        vgrupo_financeiro_id INT(10) UNSIGNED
)
BEGIN
	UPDATE categorias_financeira
	SET
	nome = vnome,
	descricao = vdescricao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified,
	grupo_financeiro_id = vgrupo_financeiro_id
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categorias_financeira_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `categorias_financeira_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_insere`(
	vnome VARCHAR(100),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME,
        vgrupo_financeiro_id INT(10) UNSIGNED
)
BEGIN
	INSERT INTO categorias_financeira
	(nome, descricao, empresa_id, user_id, created, modified, grupo_financeiro_id)
	VALUES
	(vnome, vdescricao, vempresa_id, vuser_id, vcreated, vmodified, vgrupo_financeiro_id);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categorias_financeira_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `categorias_financeira_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_financeira_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome gruposfinanceiro_descricao
	FROM categorias_financeira T1
        LEFT JOIN grupos_financeiro T2
               ON T1.grupo_financeiro_id = T2.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categorias_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `categorias_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categorias_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM categorias T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categoria_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `categoria_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categoria_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vempresa_id INT(11) UNSIGNED,
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE categorias
	SET
	nome = vnome,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categoria_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `categoria_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categoria_insere`(
	vnome VARCHAR(150),
        vempresa_id INT(11) UNSIGNED,
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO categorias
	(nome, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `categoria_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `categoria_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `categoria_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM categorias 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contas_financeira_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `contas_financeira_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_altera`(
	vid INT(10) UNSIGNED,
        vnome VARCHAR(100),
        vdescricao TEXT,
        vbanco_id TINYINT(4) UNSIGNED,
        vagencia VARCHAR(10),
        vnumero VARCHAR(10),
        vvariacao VARCHAR(5),
        vtipo_conta CHAR(1),
        vtipo_aplicacao CHAR(1),
        vempresa_id INT(10) UNSIGNED,
        vuser_id INT(10) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE contas_financeira
	SET
	nome = vnome,
	descricao = vdescricao,
	banco_id = vbanco_id,
	agencia = vagencia,
	numero = vnumero,
	variacao = vvariacao,
	tipo_conta = vtipo_conta,
	tipo_aplicacao = vtipo_aplicacao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contas_financeira_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `contas_financeira_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_insere`(
	vnome VARCHAR(100),
        vdescricao TEXT,
        vbanco_id TINYINT(4) UNSIGNED,
        vagencia VARCHAR(10),
        vnumero VARCHAR(10),
        vvariacao VARCHAR(5),
        vtipo_conta CHAR(1),
        vtipo_aplicacao CHAR(1),
        vempresa_id INT(10) UNSIGNED,
        vuser_id INT(10) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO contas_financeira
	(nome, descricao, banco_id, agencia, numero, variacao, tipo_conta, tipo_aplicacao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vbanco_id, vagencia, vnumero, vvariacao, vtipo_conta, vtipo_aplicacao, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contas_financeira_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `contas_financeira_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_financeira_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome banco_descricao
	FROM contas_financeira T1
        LEFT JOIN bancos T2
               ON T1.banco_id = T2.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contatos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `contatos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contatos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM contatos T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contato_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `contato_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contato_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(45),
        vemail VARCHAR(100),
        vtelefone VARCHAR(20),
        vcongregacao_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE contatos
	SET
	nome = vnome,
	email = vemail,
	telefone = vtelefone,
	congregacao_id = vcongregacao_id,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contato_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `contato_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contato_insere`(
	vnome VARCHAR(45),
        vemail VARCHAR(100),
        vtelefone VARCHAR(20),
        vcongregacao_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO contatos
	(nome, email, telefone, congregacao_id, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vemail, vtelefone, vcongregacao_id, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `contato_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `contato_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `contato_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM contatos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `departamentos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamentos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamentos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM departamentos T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `departamento_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamento_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_altera`(
	vid 		INT(11) UNSIGNED,
        vnome 		VARCHAR(255),
        vabreviacao 	VARCHAR(255),
        veleicao	CHAR(1),
        vinteresse	CHAR(1),
        vempresa_id	INT(11),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE departamentos
	SET
	nome = vnome,
	abreviacao = vabreviacao,
	eleicao = veleicao,
	interesse = vinteresse,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `departamento_exclui` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamento_exclui` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_exclui`(
	vid 		INT(11) UNSIGNED,
        vempresa_id	INT(11)
)
BEGIN
	DELETE
	FROM departamentos
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `departamento_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamento_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_insere`(
	vnome 		VARCHAR(80),
        vabreviacao 	VARCHAR(255),
        veleicao	CHAR(1),
        vinteresse	CHAR(1),
        vempresa_id 	INT(11),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	INSERT INTO departamentos
	(nome, abreviacao, eleicao, interesse, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vabreviacao, veleicao, vinteresse, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `departamento_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamento_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM departamentos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `dom_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `dom_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `dom_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vobservacoes TEXT,
        vuser_id INT(11) UNSIGNED,
        vempresa_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE dons
	SET
	nome = vnome,
	observacoes = vobservacoes,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `dom_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `dom_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `dom_insere`(
	vnome VARCHAR(150),
        vobservacoes TEXT,
        vuser_id INT(11) UNSIGNED,
        vempresa_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO dons
	(nome, observacoes, user_id, empresa_id, created, modified)
	VALUES
	(vnome, vobservacoes, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `dom_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `dom_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `dom_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM dons 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `dons_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `dons_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `dons_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM dons T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `editoras_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `editoras_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `editoras_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM editoras T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `editora_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `editora_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `editora_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE editoras
	SET
	nome = vnome,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `editora_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `editora_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `editora_insere`(
	vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO editoras
	(nome, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `editora_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `editora_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `editora_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM editoras 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `empresas_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `empresas_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `empresas_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM empresas T1
        WHERE T1.id = IFNULL(vempresa, T1.id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `empresa_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `empresa_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_altera`(
	IN `vid` INT(11),
	IN `venderecos_id` INT(11),
	IN `vativo` CHAR(1),
	IN `vcliente` CHAR(1),
	IN `vnome` VARCHAR(150),
	IN `vcnpj` VARCHAR(14),
	IN `vtelefone` VARCHAR(15),
	IN `vwhatsapp` VARCHAR(45),
	IN `vnumero` VARCHAR(5),
	IN `vcomplemento` VARCHAR(50),
	IN `vcelular` VARCHAR(45),
	IN `vabreviacao` VARCHAR(45),
	IN `vemail` VARCHAR(150),
	IN `vmatriz_id` VARCHAR(5),
	IN `vtipo` INT(11),
	IN `vsubdomain` VARCHAR(15)
)
BEGIN
	UPDATE empresas
	SET
	nome = vnome,
	enderecos_id = venderecos_id,
	ativo = vativo,
	cliente = vcliente,
	cnpj = vcnpj,
	telefone = vtelefone,
	whatsapp = vwhatsapp,
	numero = vnumero,
  complemento = vcomplemento,
	celular = vcelular,
	abreviacao = vabreviacao,
	email = vemail,
	matriz_id = vmatriz_id,
	tipo = vtipo,
	subdomain = vsubdomain
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `empresa_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `empresa_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_insere`(
	IN `venderecos_id` INT(11),
	IN `vativo` CHAR(1),
	IN `vcliente` CHAR(1),
	IN `vnome` VARCHAR(150),
	IN `vcnpj` VARCHAR(14),
	IN `vtelefone` VARCHAR(15),
	IN `vwhatsapp` VARCHAR(45),
	IN `vnumero` VARCHAR(5),
	IN `vcomplemento` VARCHAR(50),
	IN `vcelular` VARCHAR(45),
	IN `vabreviacao` VARCHAR(45),
	IN `vemail` VARCHAR(150),
	IN `vmatriz_id` VARCHAR(5),
	IN `vtipo` INT(11),
	IN `vsubdomain` VARCHAR(15)
)
BEGIN
	INSERT INTO empresas
	(enderecos_id, ativo, cliente, nome, cnpj, telefone, whatsapp, numero, complemento, celular, abreviacao, email, matriz_id, tipo, subdomain)
	VALUES
	(venderecos_id, vativo, vcliente, vnome, vcnpj, vtelefone, vwhatsapp, vnumero, vcomplemento, vcelular, vabreviacao, vemail, vmatriz_id, vtipo, vsubdomain);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `empresa_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `empresa_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_seleciona`(
	vid INT(11)
)
BEGIN
	SELECT *
	FROM empresas 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `enderecos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `enderecos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `enderecos_seleciona`(
	vcep VARCHAR(8)
)
BEGIN
	SELECT id
	      ,cep
	      ,logradouro
	      ,bairro
	      ,localidade
	      ,estado_id uf
	      ,user_id
	      ,created
	      ,modified
	FROM enderecos
	WHERE cep = vcep;
END */$$
DELIMITER ;

/* Procedure structure for procedure `endereco_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `endereco_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_altera`(
	IN `vid` INT(11) UNSIGNED,
	IN `vlogradouro` VARCHAR(70),
	IN `vbairro` VARCHAR(45),
	IN `vcep` VARCHAR(10),
	IN `vcidade` VARCHAR(100),
	IN `vestado_id` INT(11) UNSIGNED,
	IN `vuser_id` INT(11),
	IN `vempresa_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE enderecos
	SET
	logradouro = vlogradouro,
	bairro = vbairro,
	cep = vcep,
	cidade = vcidade,
	estado_id = vestado_id,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `endereco_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `endereco_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_insere`(
	IN `vlogradouro` VARCHAR(70),
	IN `vbairro` VARCHAR(45),
	IN `vcep` VARCHAR(10),
	IN `vcidade` VARCHAR(100),
	IN `vestado_id` INT(11) UNSIGNED,
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO enderecos
	(logradouro, bairro, cep, localidade, estado_id, user_id, created, modified)
	VALUES
	(vlogradouro, vbairro, vcep, vcidade, vestado_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `endereco_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `endereco_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_seleciona`(
	vid INT(11)
)
BEGIN
	SELECT *
	FROM enderecos
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `escolaridades_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `escolaridades_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `escolaridades_seleciona`()
BEGIN
	SELECT T1.*
	FROM escolaridades T1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `escolaridade_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `escolaridade_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `escolaridade_altera`(
	vid INT(11) UNSIGNED,
        vdescricao VARCHAR(100),
        vobs TEXT,
        vcreated DATETIME,
        vmodified DATETIME,
        vuser_id INT(11)
)
BEGIN
	UPDATE escolaridades
	SET
	descricao = vdescricao,
	obs = vobs,
	created = vcreated,
	modified = vmodified,
	user_id = vuser_id
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `escolaridade_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `escolaridade_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `escolaridade_insere`(
	vdescricao VARCHAR(100),
        vobs TEXT,
        vcreated DATETIME,
        vmodified DATETIME,
        vuser_id INT(11)
)
BEGIN
	INSERT INTO escolaridades
	(descricao, obs, created, modified, user_id)
	VALUES
	(vdescricao, vobs, vcreated, vmodified, vuser_id);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `escolaridade_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `escolaridade_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `escolaridade_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM escolaridades 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `estados_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `estados_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `estados_seleciona`()
BEGIN
	SELECT *
	FROM estados;
END */$$
DELIMITER ;

/* Procedure structure for procedure `estado_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `estado_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `estado_altera`(
	vid INT(11) UNSIGNED,
        vsigla VARCHAR(2),
        vcodibge INT(11),
        vnome VARCHAR(45)
)
BEGIN
	UPDATE estados
	SET
	sigla = vsigla,
	codibge = vcodibge,
	nome = vnome
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `estado_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `estado_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `estado_insere`(
	vsigla VARCHAR(2),
        vcodibge INT(11),
        vnome VARCHAR(45)
)
BEGIN
	INSERT INTO estados
	(sigla, codibge, nome)
	VALUES
	(vsigla, vcodibge, vnome);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `estado_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `estado_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `estado_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM estados 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedores_altera_status` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedores_altera_status` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedores_altera_status`(
	vcodigo 	INT(11),
        vempresas_id 	INT(11),
        vativo 		CHAR(1),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE fornecedores
	SET
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vcodigo
	  AND empresa_id = vempresas_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedores_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedores_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedores_seleciona`(
				vativo CHAR(1),
        vempresa INT(11)
)
BEGIN
	SELECT T1.*, T3.descricao tipo_descricao
	FROM fornecedores T1
	LEFT JOIN tipo_fornecedores	T3
				 ON T1.tipo = T3.id
	WHERE T1.empresa_id = vempresa
 		AND IFNULL(T1.ativo,"") = CASE 
						WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
						ELSE vativo
					  END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedor_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedor_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedor_altera`(
	vid 		INT(10) UNSIGNED,
        vnome_fantasia 	VARCHAR(150),
        vrazao_social 	VARCHAR(150),
        vcnpj 		VARCHAR(15),
        vemail 		VARCHAR(100),
        vtelefone 	VARCHAR(11),
        vtelefone2 	VARCHAR(11),
        vendereco_id 	INT(11) UNSIGNED,
        vnumero 	VARCHAR(45),
        vcomplemento 	VARCHAR(256),
        vtipo 		INT(10) UNSIGNED,
        vativo 		CHAR(1),
        vempresa_id 	INT(11) UNSIGNED,
        vuser_id 	INT(11) UNSIGNED,
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE fornecedores
	SET
	nome_fantasia = vnome_fantasia,
	razao_social = vrazao_social,
	cnpj = vcnpj,
	email = vemail,
	telefone = vtelefone,
	telefone2 = vtelefone2,
	endereco_id = vendereco_id,
	enderecos_numero = vnumero,
	enderecos_complemento = vcomplemento,
	tipo = vtipo,
	ativo = vativo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedor_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedor_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedor_insere`(
	IN `vnome_fantasia` 	VARCHAR(150),
	IN `vrazao_social` 	VARCHAR(150),
	IN `vcnpj` 		VARCHAR(15),
	IN `vemail` 		VARCHAR(100),
	IN `vtelefone` 		VARCHAR(11),
	IN `vtelefone2` 	VARCHAR(11),
	IN  vendereco_id 	INT(11) UNSIGNED,
        IN  vnumero 		VARCHAR(45),
        IN  vcomplemento 	VARCHAR(256),
	IN `vtipo` 		INT(10) UNSIGNED,
	IN `vempresa_id` 	INT(10) UNSIGNED,
	IN `vuser_id` 		INT(10) UNSIGNED,
	IN `vcreated` 		DATETIME,
	IN `vmodified` 		DATETIME
)
BEGIN
	INSERT INTO fornecedores
	(nome_fantasia, razao_social, cnpj, email, telefone, telefone2, endereco_id, enderecos_numero, enderecos_complemento, tipo, ativo, empresa_id, user_id, created, modified)
	VALUES
	(vnome_fantasia, vrazao_social, vcnpj, vemail, vtelefone, vtelefone2, vendereco_id, vnumero, vcomplemento, vtipo, 'S', vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedor_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedor_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedor_seleciona`(
	vid INT(10) UNSIGNED,
	vempresa INT(11)
)
BEGIN
	SELECT *
	FROM fornecedores 
	WHERE empresa_id = vempresa
		AND id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `grupos_financeiro_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `grupos_financeiro_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `grupos_financeiro_altera`(
	vid INT(10) UNSIGNED,
        vnome VARCHAR(100),
        vdescricao TEXT,
        vtipo CHAR(1),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE grupos_financeiro
	SET
	nome = vnome,
	descricao = vdescricao,
	tipo = vtipo,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `grupos_financeiro_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `grupos_financeiro_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `grupos_financeiro_insere`(
	vnome VARCHAR(100),
        vdescricao TEXT,
        vtipo CHAR(1),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO grupos_financeiro
	(nome, descricao, tipo, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vtipo, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `grupos_financeiro_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `grupos_financeiro_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `grupos_financeiro_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM grupos_financeiro T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `igrejas_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `igrejas_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `igrejas_seleciona`()
BEGIN
	SELECT i.*
	FROM igrejas i;
END */$$
DELIMITER ;

/* Procedure structure for procedure `igreja_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `igreja_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `igreja_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT i.*
	FROM igrejas i
	WHERE i.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `item_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `item_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `item_altera`(
	vid INT(11) UNSIGNED,
        visbn VARCHAR(50),
        vtitulo VARCHAR(150),
        vfoto VARCHAR(150),
        vpaginas INT(11),
        vpreco DECIMAL(18,2),
        vcomentarios TEXT,
        vestoque INT(11),
        vautor_id INT(11) UNSIGNED,
        vcategoria_id INT(11) UNSIGNED,
        veditora_id INT(11) UNSIGNED,
        vtipo_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE itens
	SET
	isbn = visbn,
	titulo = vtitulo,
	foto = vfoto,
	paginas = vpaginas,
	preco = vpreco,
	comentarios = vcomentarios,
	estoque = vestoque,
	autor_id = vautor_id,
	categoria_id = vcategoria_id,
	editora_id = veditora_id,
	tipo_id = vtipo_id,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `item_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `item_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `item_insere`(
	visbn VARCHAR(50),
        vtitulo VARCHAR(150),
        vfoto VARCHAR(150),
        vpaginas INT(11),
        vpreco DECIMAL(18,2),
        vcomentarios TEXT,
        vestoque INT(11),
        vautor_id INT(11) UNSIGNED,
        vcategoria_id INT(11) UNSIGNED,
        veditora_id INT(11) UNSIGNED,
        vtipo_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO itens
	(isbn, titulo, foto, paginas, preco, comentarios, estoque, autor_id, categoria_id, editora_id, tipo_id, empresa_id, user_id, created, modified)
	VALUES
	(visbn, vtitulo, vfoto, vpaginas, vpreco, vcomentarios, vestoque, vautor_id, vcategoria_id, veditora_id, vtipo_id, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `item_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `item_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `item_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM itens 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `itens_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `itens_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `itens_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome autor_descricao, T3.nome categoria_descricao, T4.nome editora_descricao, T5.nome tipobiblioteca_descricao
	FROM itens T1
        LEFT JOIN autores T2
               ON T1.autor_id = T2.id
        LEFT JOIN categorias T3
               ON T1.categoria_id = T3.id
        LEFT JOIN editoras T4
               ON T1.editora_id = T4.id
        LEFT JOIN tipo_biblioteca T5
               ON T1.tipo_id = T5.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `locais_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `locais_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `locais_seleciona`(
  vativo CHAR(1),
  vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM local T1
        WHERE T1.empresa_id = vempresa 
          AND IFNULL(T1.ativo,"") = CASE
					WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
					ELSE vativo
				    END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `local_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `local_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `local_altera`(
	vcodigo 	INT(11),
        vnome 		VARCHAR(40),
        vsede 		CHAR(1),
        vempresas_id 	INT(11),
        vativo 		CHAR(1),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE local
	SET
	nome = vnome,
	sede = vsede,
	ativo = IFNULL(vativo, ativo),
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vcodigo
	  AND empresa_id = vempresas_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `local_altera_status` */

/*!50003 DROP PROCEDURE IF EXISTS  `local_altera_status` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `local_altera_status`(
	vcodigo 	INT(11),
        vempresas_id 	INT(11),
        vativo 		CHAR(1),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	UPDATE local
	SET
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vcodigo
	  AND empresa_id = vempresas_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `local_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `local_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `local_insere`(
	vnome 		VARCHAR(40),
        vsede 		CHAR(1),
        vempresas_id 	INT(11),
        vativo 		CHAR(1),
        vuser_id 	INT(11),
        vcreated 	DATETIME,
        vmodified 	DATETIME
)
BEGIN
	INSERT INTO local
	(nome, sede, empresa_id, ativo, user_id, created, modified)
	VALUES
	(vnome, vsede, vempresas_id, IFNULL(vativo, "N"), vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `local_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `local_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `local_seleciona`(
  vid	INT(11) UNSIGNED
)
BEGIN
	SELECT T1.*
	FROM local T1
        WHERE T1.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_cargos_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_cargos_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_cargos_insere`(
	vmembro_id 		INT(11),
        vcargo_id 		INT(11),
        vempresa_id		INT(11),
        vativo		 	CHAR(1),
        vuser_id 		INT(11),
        vcreated 		DATETIME,
        vmodified 		DATETIME
)
BEGIN
	INSERT INTO assoc_membros_cargos
	(membro_id,
	 cargo_id,
	 ativo,
	 empresa_id,
	 user_id,
	 created,
	 modified
	)
	VALUES
	(vmembro_id,
	 vcargo_id,
	 vativo,
	 vempresa_id,
	 vuser_id,
	 vcreated,
	 vmodified
	);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_frequencia_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_frequencia_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_frequencia_seleciona`(
	vid 	INT(11) UNSIGNED,
	vemp_id	INT(11)
)
BEGIN
	IF vid IS NULL THEN
		SELECT mf.*
		FROM membros_frequencia mf
		WHERE mf.empresa_id = vemp_id
		ORDER BY status;
	ELSE
		SELECT mf.*
		FROM membros_frequencia mf
		WHERE mf.id = vid
		  AND mf.empresa_id = vemp_id
		ORDER BY STATUS;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_ft_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_ft_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_ft_seleciona`(
	vpar 		TEXT(10000),
	vempresa_id	INT(11),
	vativo		CHAR(1)
)
BEGIN
	IF vativo IS NULL THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE) 
		  AND T1.empresa_id = vempresa_id
		ORDER BY T1.nome;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND T1.empresa_id = vempresa_id
		  AND T1.ativo = 1
		ORDER BY T1.nome;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND T1.empresa_id = vempresa_id
		  AND T1.ativo <> 1
		ORDER BY T1.nome;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_ft_update` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_ft_update` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_ft_update`(
	vid 		INT(11),
	vempresa_id	INT(11),
	vfull_text	TEXT
)
BEGIN
	UPDATE membros
	SET membros_ft = vfull_text
	WHERE id = vid
	  AND empresa_id = vempresa_id; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_quorum_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_quorum_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_quorum_seleciona`(
	IN `vquorum` CHAR(1),
	IN `vempresa` INT(11)
)
BEGIN
	SELECT m.*, c.nome cargo_nome
	FROM membros m
	INNER JOIN membros_frequencia mf
		ON m.frequencia_id = mf.id
  LEFT JOIN assoc_membros_cargos mc
    ON m.id = mc.membro_id
  LEFT JOIN cargos c
    ON mc.cargo_id = c.id  
	WHERE mf.quorum = IFNULL(vquorum, mf.quorum)
	  AND m.empresa_id = vempresa;
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `membros_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `membros_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_seleciona`(
	vempresa INT(11),
	vativo	 CHAR(1)
)
BEGIN
	IF vativo IS NULL THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE T1.empresa_id = 1
		ORDER BY T1.nome;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		LEFT JOIN membros_frequencia mf
		       ON T1.frequencia_id = mf.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE T1.empresa_id = vempresa
		  AND mf.status = 'A'
		ORDER BY T1.nome;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		LEFT JOIN membros_frequencia mf
		       ON T1.frequencia_id = mf.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE T1.empresa_id = vempresa
		  AND mf.status <> 'A'
		ORDER BY T1.nome;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_altera`(
	vid 			INT(11) UNSIGNED,
        vfrequencia 		iNT(11),
        vnome 			VARCHAR(100),
        vsexo 			CHAR(1),
        vdatanascimento 	DATE,
        vnaturalidade 		VARCHAR(100),
        vestado_id 		INT(11) UNSIGNED,
        vestadocivil 		INT(11),
        vlatitude 		VARCHAR(50),
        vlongitude 		VARCHAR(50),
        vrg 			VARCHAR(20),
        vorgao_emissor 		VARCHAR(20),
        vdata_expedicao 	DATE,
        vcpf 			VARCHAR(20),
        vemail 			VARCHAR(150),
        vfone 			VARCHAR(20),
        vcel 			VARCHAR(20),
        vescolaridade_id 	INT(11) UNSIGNED,
        vprofissao_id 		INT(11) UNSIGNED,
        vempresa 		VARCHAR(150),
        vdatabatismo 		DATE,
        vigrejabatismo 		INT(11),
        vpastorbatismo 		INT(11),
        vultimaigreja 		INT(11),
        vdatamembro 		DATE,
        vcargo_id 		INT(11) UNSIGNED,
        vempresa_id 		INT(11),
        venderecos_id		INT(11),
        venderecos_numero	VARCHAR(45),
        venderecos_complemento	VARCHAR(256),
        vuser_id 		INT(11),
        vcreated 		DATETIME,
        vmodified 		DATETIME,
        vtipo 			CHAR(1)
)
BEGIN
	UPDATE membros
	SET
	frequencia_id = vfrequencia,
	nome = vnome,
	sexo = vsexo,
	datanascimento = vdatanascimento,
	naturalidade = vnaturalidade,
	estado_id = vestado_id,
	estadocivil = vestadocivil,
	latitude = vlatitude,
	longitude = vlongitude,
	rg = vrg,
	orgao_emissor = vorgao_emissor,
        data_expedicao = vdata_expedicao,
	cpf = vcpf,
	email = vemail,
	fone = vfone,
	cel = vcel,
	escolaridade_id = vescolaridade_id,
	profissao_id = vprofissao_id,
	empresa = vempresa,
	databatismo = vdatabatismo,
	igrejas_id = vigrejabatismo,
	pastorbatismo = vpastorbatismo,
	ultimaigreja = vultimaigreja,
	datamembro = vdatamembro,
	cargo_id = vcargo_id,
	empresa_id = vempresa_id,
	enderecos_id = venderecos_id,
	enderecos_numero = venderecos_numero,
	enderecos_complemento = venderecos_complemento,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified,
	tipo = vtipo
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_ig_ant_sel` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_ig_ant_sel` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_ig_ant_sel`(
	vid 		INT(11),
	vempresa_id	INT(11)
)
BEGIN
	SELECT e.`id`,
               e.`nome`
	FROM assoc_membros_empresas ame
	INNER JOIN membros m
		ON ame.membro_id = m.`id`
	INNER JOIN empresas e
		ON ame.empresa_ant_id = e.`id`
	WHERE ame.membro_id = vid
	  AND ame.empresa_id = vempresa_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_insere`(
	vfrequencia 		INT(11),
        vnome 			VARCHAR(100),
        vsexo 			CHAR(1),
        vdatanascimento 	DATE,
        vnaturalidade 		VARCHAR(100),
        vestado_id 		INT(11) UNSIGNED,
        vestadocivil 		INT(11),
        vlatitude 		VARCHAR(50),
        vlongitude 		VARCHAR(50),
        vrg 			VARCHAR(20),
        vorgao_emissor 		VARCHAR(20),
        vdata_expedicao 	DATE,
        vcpf 			VARCHAR(20),
        vemail 			VARCHAR(150),
        vfone 			VARCHAR(20),
        vcel 			VARCHAR(20),
        vescolaridade_id 	INT(11) UNSIGNED,
        vprofissao_id 		INT(11) UNSIGNED,
        vempresa 		VARCHAR(150),
        vdatabatismo 		DATE,
        vigrejabatismo 		VARCHAR(30),
        vpastorbatismo 		VARCHAR(20),
        vultimaigreja 		VARCHAR(30),
        vdatamembro 		DATE,
        vcargo_id 		INT(11) UNSIGNED,
        vempresa_id 		INT(11),
        venderecos_id		INT(11),
        venderecos_numero	VARCHAR(45),
        venderecos_complemento	VARCHAR(256),
        vuser_id 		INT(11),
        vcreated 		DATETIME,
        vmodified 		DATETIME,
        vtipo 			CHAR(1)
)
BEGIN
	INSERT INTO membros
	(frequencia_id,
	 nome,
	 sexo,
	 datanascimento,
	 naturalidade,
	 estado_id,
	 estadocivil,
	 latitude,
	 longitude,
	 rg,
	 orgao_emissor,
         data_expedicao,
	 cpf,
	 email,
	 fone,
	 cel,
	 escolaridade_id,
	 profissao_id,
	 empresa,
	 databatismo,
	 igrejas_id,
	 pastorbatismo,
	 ultimaigreja,
	 datamembro,
	 igrejasanteriores,
	 cargo_id,
	 empresa_id,
	 enderecos_id,
	 enderecos_numero,
	 enderecos_complemento,
	 user_id,
	 created,
	 modified,
	 tipo)
	VALUES
	(vfrequencia,
	 vnome,
	 vsexo,
	 vdatanascimento,
	 vnaturalidade,
	 vestado_id,
	 vestadocivil,
	 vlatitude,
	 vlongitude,
	 vrg,
	 vorgao_emissor,
         vdata_expedicao,
	 vcpf,
	 vemail,
	 vfone,
	 vcel,
	 vescolaridade_id,
	 vprofissao_id,
	 vempresa,
	 vdatabatismo,
	 vigrejabatismo,
	 vpastorbatismo,
	 vultimaigreja,
	 vdatamembro,
	 vcargo_id,
	 vempresa_id,
	 venderecos_id,
	 venderecos_numero,
	 venderecos_complemento,
	 vuser_id,
	 vcreated,
	 vmodified,
	 vtipo);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT m.*
	FROM membros m
	WHERE m.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_bem_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_bem_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_bem_altera`(
	vid INT(11) UNSIGNED,
        vtipo INT(11),
        vquantidade INT(11),
        vsaldo INT(11),
        vmotivo VARCHAR(50),
        vbem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE movimentacao_bens
	SET
	tipo = vtipo,
	quantidade = vquantidade,
	saldo = vsaldo,
	motivo = vmotivo,
	bem_id = vbem_id,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_bem_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_bem_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_bem_insere`(
	vtipo INT(11),
        vquantidade INT(11),
        vsaldo INT(11),
        vmotivo VARCHAR(50),
        vbem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO movimentacao_bens
	(tipo, quantidade, saldo, motivo, bem_id, user_id, empresa_id, created, modified)
	VALUES
	(vtipo, vquantidade, vsaldo, vmotivo, vbem_id, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_bem_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_bem_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_bem_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM movimentacao_bens 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_bens_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_bens_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_bens_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome bem_descricao
	FROM movimentacao_bens T1
        LEFT JOIN bens T2
               ON T1.bem_id = T2.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_item_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_item_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_item_altera`(
	vid INT(11) UNSIGNED,
        vquantidade INT(11),
        vdevolvido INT(11),
        vmembro_id INT(11) UNSIGNED,
        vitem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE movimentacao_itens
	SET
	quantidade = vquantidade,
	devolvido = vdevolvido,
	membro_id = vmembro_id,
	item_id = vitem_id,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_item_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_item_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_item_insere`(
	vquantidade INT(11),
        vdevolvido INT(11),
        vmembro_id INT(11) UNSIGNED,
        vitem_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO movimentacao_itens
	(quantidade, devolvido, membro_id, item_id, user_id, empresa_id, created, modified)
	VALUES
	(vquantidade, vdevolvido, vmembro_id, vitem_id, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_item_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_item_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_item_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM movimentacao_itens 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `movimentacao_itens_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `movimentacao_itens_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_itens_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome membro_descricao, T3.titulo item_descricao
	FROM movimentacao_itens T1
        LEFT JOIN membros T2
               ON T1.membro_id = T2.id
        LEFT JOIN itens T3
               ON T1.item_id = T3.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pastores_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `pastores_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pastores_seleciona`(
	vempresa_id INT(11)
)
BEGIN
	SELECT DISTINCT T1.*
	      ,(SELECT categoria
	        FROM assoc_empresas_pastores
	        WHERE pastor_id = T1.id
	          AND empresa_id = vempresa_id) categoria
	FROM pastores T1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pastor_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `pastor_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pastor_altera`(
	IN `vid` INT(10) UNSIGNED,
	IN `vnome` VARCHAR(70),
	IN `vtratamento` VARCHAR(15),
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	UPDATE pastores
	SET
	nome = vnome,
	tratamento = vtratamento,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pastor_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `pastor_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pastor_insere`(
	IN `vnome` VARCHAR(70),
	IN `vtratamento` VARCHAR(15),
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO pastores
	(nome, tratamento, user_id, created, modified)
	VALUES
	(vnome, vtratamento, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pastor_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `pastor_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pastor_seleciona`(
	vid INT(10) UNSIGNED,
	vempresa_id INT(11)
)
BEGIN
	SELECT P.*, EP.dt_entrada, EP.ata_entrada, EP.dt_saida, EP.ata_saida, EP.categoria
	FROM pastores P
	LEFT JOIN assoc_empresas_pastores EP
		ON P.id = EP.pastor_id
	   AND EP.empresa_id = vempresa_id	
	WHERE P.id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `profissao_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `profissao_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `profissao_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE profissoes
	SET
	nome = vnome,
	descricao = vdescricao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `profissao_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `profissao_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `profissao_insere`(
	vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO profissoes
	(nome, descricao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `profissao_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `profissao_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `profissao_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM profissoes 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `profissoes_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `profissoes_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `profissoes_seleciona`()
BEGIN
	SELECT T1.*
	FROM profissoes T1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `relacionamentos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `relacionamentos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionamentos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.nome membro_descricao, T3.descricao tiporelacionamento_descricao, T4.nome membro_descricao
	FROM relacionamentos T1
        LEFT JOIN membros T2
               ON T1.membro_id = T2.id
        LEFT JOIN tiporelacionamentos T3
               ON T1.tiporelacionamento_id = T3.id
        LEFT JOIN membros T4
               ON T1.membro2_id = T4.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `relacionamento_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `relacionamento_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionamento_altera`(
	vid INT(11) UNSIGNED,
        vmembro_id INT(11) UNSIGNED,
        vtiporelacionamento_id INT(11) UNSIGNED,
        vmembro2_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE relacionamentos
	SET
	membro_id = vmembro_id,
	tiporelacionamento_id = vtiporelacionamento_id,
	membro2_id = vmembro2_id,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `relacionamento_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `relacionamento_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionamento_insere`(
	vmembro_id INT(11) UNSIGNED,
        vtiporelacionamento_id INT(11) UNSIGNED,
        vmembro2_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO relacionamentos
	(membro_id, tiporelacionamento_id, membro2_id, empresa_id, user_id, created, modified)
	VALUES
	(vmembro_id, vtiporelacionamento_id, vmembro2_id, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `relacionamento_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `relacionamento_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `relacionamento_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM relacionamentos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `representante_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `representante_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `representante_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vemail VARCHAR(150),
        vidade INT(11),
        vddd INT(11),
        vtelefone INT(11),
        vtipo_telefone INT(11),
        vcidade VARCHAR(100),
        vestado VARCHAR(2),
        vclassificacao INT(11),
        vinfoad TEXT,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE representante
	SET
	nome = vnome,
	email = vemail,
	idade = vidade,
	ddd = vddd,
	telefone = vtelefone,
	tipo_telefone = vtipo_telefone,
	cidade = vcidade,
	estado = vestado,
	classificacao = vclassificacao,
	infoad = vinfoad,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `representante_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `representante_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `representante_insere`(
	vnome VARCHAR(150),
        vemail VARCHAR(150),
        vidade INT(11),
        vddd INT(11),
        vtelefone INT(11),
        vtipo_telefone INT(11),
        vcidade VARCHAR(100),
        vestado VARCHAR(2),
        vclassificacao INT(11),
        vinfoad TEXT,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO representante
	(nome, email, idade, ddd, telefone, tipo_telefone, cidade, estado, classificacao, infoad, created, modified)
	VALUES
	(vnome, vemail, vidade, vddd, vtelefone, vtipo_telefone, vcidade, vestado, vclassificacao, vinfoad, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `representante_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `representante_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `representante_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM representante T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tiporelacionamentos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tiporelacionamentos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tiporelacionamentos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM tiporelacionamentos T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tiporelacionamento_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `tiporelacionamento_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tiporelacionamento_altera`(
	vid INT(11) UNSIGNED,
        vdescricao VARCHAR(45),
        vobs TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE tiporelacionamentos
	SET
	descricao = vdescricao,
	obs = vobs,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tiporelacionamento_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `tiporelacionamento_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tiporelacionamento_insere`(
	vdescricao VARCHAR(45),
        vobs TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO tiporelacionamentos
	(descricao, obs, empresa_id, user_id, created, modified)
	VALUES
	(vdescricao, vobs, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tiporelacionamento_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tiporelacionamento_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tiporelacionamento_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM tiporelacionamentos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_bem_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_bem_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE tipo_bens
	SET
	nome = vnome,
	descricao = vdescricao,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_bem_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_bem_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_insere`(
	vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO tipo_bens
	(nome, descricao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_bem_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_bem_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bem_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM tipo_bens 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_bens_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_bens_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_bens_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM tipo_bens T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_biblioteca_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_biblioteca_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_biblioteca_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE tipo_biblioteca
	SET
	nome = vnome,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_biblioteca_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_biblioteca_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_biblioteca_insere`(
	vnome VARCHAR(150),
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO tipo_biblioteca
	(nome, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_biblioteca_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_biblioteca_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_biblioteca_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM tipo_biblioteca T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_fornecedores_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_fornecedores_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_fornecedores_seleciona`(
				vativo CHAR(1)
)
BEGIN
	SELECT T1.*
	FROM tipo_fornecedores T1
	WHERE IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
																	 ELSE vativo
															END;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_fornecedor_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_fornecedor_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_fornecedor_altera`(
				vid INT(11) UNSIGNED,
        vdescricao VARCHAR(50),
        vativo CHAR(1),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE tipo_fornecedores
	SET
	descricao = vdescricao,
	ativo = vativo,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_fornecedor_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_fornecedor_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_fornecedor_insere`(
	IN `vdescricao` VARCHAR(50),
	IN `vuser_id` INT(11),
	IN `vcreated` DATETIME,
	IN `vmodified` DATETIME
)
BEGIN
	INSERT INTO tipo_fornecedores
	(descricao, ativo, user_id, created, modified)
	VALUES
	(vdescricao, 'S', vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tipo_fornecedor_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `tipo_fornecedor_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tipo_fornecedor_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM tipo_fornecedores 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `users_empresa_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `users_empresa_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `users_empresa_insere`(
	vempresa_id	INT(11),
	vusers_id 	INT(11)
)
BEGIN
	insert into assoc_empresas_users
	(empresa_id, users_id)
	values
	(vempresa_id, vusers_id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `users_ft_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `users_ft_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `users_ft_seleciona`(
	vpar 		TEXT(10000),
	vempresa_id	INT(11),
	vativo		CHAR(1)
)
BEGIN
	IF vativo IS NULL THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE MATCH(usr.users_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND chu.id = vempresa_id
		  ORDER BY usr.nome;
	ELSEIF vativo = 'S' THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE MATCH(usr.users_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND usr.ativo = 'S'
		  AND chu.id = vempresa_id
		  ORDER BY usr.nome;
	ELSE
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE MATCH(usr.users_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND usr.ativo <> 'S'
		  AND usr.ativo IS NOT NULL
		  AND chu.id = vempresa_id
		  ORDER BY usr.nome;
	END IF;  
	END */$$
DELIMITER ;

/* Procedure structure for procedure `usuarios_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `usuarios_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `usuarios_seleciona`(
	vchurchs_id	INT(11),
	vativo		CHAR(1)
)
BEGIN
	IF vativo is NULL THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE chu.id = vchurchs_id
		ORDER BY usr.nome;
	ELSEIF vativo = 'S' THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE usr.ativo = 'S'
		  AND chu.id = vchurchs_id
		ORDER BY usr.nome;
	else
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE usr.ativo <> 'S'
		  AND usr.ativo IS NOT NULL
		  AND chu.id = vchurchs_id
		ORDER BY usr.nome;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `usuario_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `usuario_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `usuario_altera`(
	vnome 		VARCHAR(100),
	vusuario 	VARCHAR(45),
	vperfil 	TINYINT(4),
	vcpf 		VARCHAR(45),
	vemail		VARCHAR(100),
	vcelular	VARCHAR(45),
	vmodificacao	DATETIME,
	vcodigo		INT(11),
	vsenha		CHAR(64)
)
BEGIN
	UPDATE users
	SET
	perfil = vperfil,
	modified = vmodificacao,
	nome = vnome,
	username = vusuario,
	email = vemail,
	cpf = vcpf,
	celular = vcelular,
	senha = vsenha
	WHERE id = vcodigo;
END */$$
DELIMITER ;

/* Procedure structure for procedure `usuario_altera_perfil` */

/*!50003 DROP PROCEDURE IF EXISTS  `usuario_altera_perfil` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `usuario_altera_perfil`(
	vperfil 	TINYINT(4),
	vmodificacao	DATETIME,
	vcodigo 	INT(11)
)
BEGIN
	update users
	set
	perfil = vperfil,
	modified = vmodificacao
	where id = vcodigo;
END */$$
DELIMITER ;

/* Procedure structure for procedure `usuario_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `usuario_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `usuario_insere`(
	vnome 		VARCHAR(100),
	vusuario 	VARCHAR(45),
	vsenha 		CHAR(64),
	vperfil 	TINYINT(4),
	vcpf 		VARCHAR(45),
	vemail		VARCHAR(100),
	vcelular	VARCHAR(45),
	vcriacao	DATETIME,
	vmodificacao	DATETIME
)
BEGIN
	insert into users
	(username, senha, nome, email, celular, cpf, created, modified, perfil)
	values
	(vusuario, vsenha, vnome, vemail, vcelular, vcpf, vcriacao, vmodificacao, vperfil);
	select last_insert_id() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `usuario_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `usuario_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `usuario_seleciona`(
	vcodigo mediumint unsigned
)
BEGIN
	select U.*, CU.empresa_id
	from users U
	INNER JOIN assoc_empresas_users CU
		on U.id = CU.users_id
	where id = vcodigo;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
