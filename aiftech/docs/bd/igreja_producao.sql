/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 5.7.21-0ubuntu0.16.04.1 : Database - igreja
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

/*Table structure for table `assoc_empresas_pastores` */

DROP TABLE IF EXISTS `assoc_empresas_pastores`;

CREATE TABLE `assoc_empresas_pastores` (
  `empresa_id` int(11) NOT NULL,
  `pastor_id` int(11) unsigned NOT NULL,
  `dt_entrada` date DEFAULT NULL,
  `dt_saida` date DEFAULT NULL,
  `ata_entrada` int(11) unsigned DEFAULT NULL,
  `ata_saida` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
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

/*Data for the table `assoc_empresas_pastores` */

insert  into `assoc_empresas_pastores`(`empresa_id`,`pastor_id`,`dt_entrada`,`dt_saida`,`ata_entrada`,`ata_saida`,`user_id`,`created`,`modified`) values 
(1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1,35,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1,36,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1,50,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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

/*Data for the table `assoc_empresas_users` */

insert  into `assoc_empresas_users`(`empresa_id`,`users_id`) values 
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(2,6);

/*Table structure for table `ata_arquivos` */

DROP TABLE IF EXISTS `ata_arquivos`;

CREATE TABLE `ata_arquivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ata_id` int(11) unsigned NOT NULL COMMENT 'relaciona?atas:id;num',
  `nome` varchar(60) CHARACTER SET latin1 NOT NULL,
  `dataupload` date DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_ata_arquivos_has_atas_idx` (`ata_id`),
  CONSTRAINT `fk_ata_arquivos_has_atas` FOREIGN KEY (`ata_id`) REFERENCES `atas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Arquivos de Atas*Tabela Responsavel por armazenar os arquivos das atas e rela';

/*Data for the table `ata_arquivos` */

/*Table structure for table `atas` */

DROP TABLE IF EXISTS `atas`;

CREATE TABLE `atas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Atas*Cadastro de Todas as Atas do Sistema';

/*Data for the table `atas` */

insert  into `atas`(`id`,`num`,`data`,`user_id`,`empresa_id`,`created`,`modified`) values 
(1,101010,'2017-07-12',1,1,'2017-07-13 16:13:00','2017-07-13 16:22:00'),
(2,101010,NULL,1,1,'2017-07-13 16:14:00','2017-07-13 16:14:00'),
(3,101010,NULL,1,1,'2017-07-13 16:18:00','2017-07-13 16:18:00');

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

/*Data for the table `autores` */

/*Table structure for table `bancos` */

DROP TABLE IF EXISTS `bancos`;

CREATE TABLE `bancos` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `número` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bancos` */

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Bens*Cadastro de Bens do sistema.';

/*Data for the table `bens` */

insert  into `bens`(`id`,`nome`,`identificacao`,`num_serie`,`num_ativo`,`garantia`,`descricao`,`observacao`,`data_compra`,`valor_unitario`,`quantidade`,`departamento_id`,`congregacao_id`,`membro_id`,`tipo_bem_id`,`user_id`,`empresa_id`,`created`,`modified`) values 
(1,'asdfasdfasdfasdf','22222',NULL,NULL,NULL,'asfda','asdfasdf\nasdfasasdfasdf','2017-07-11',10.00,NULL,1,NULL,NULL,NULL,1,1,'2017-07-14 07:29:00','2017-07-14 08:55:00'),
(2,'asfasdfasf','1111',NULL,NULL,NULL,'asdasfdsadfasdfasdfasdf',NULL,'2017-07-05',10.00,NULL,1,NULL,NULL,NULL,1,1,'2017-07-14 08:47:00','2017-07-14 08:47:00');

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

/*Data for the table `calendarios` */

/*Table structure for table `cargos` */

DROP TABLE IF EXISTS `cargos`;

CREATE TABLE `cargos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1 COMMENT 'descricao?Descrição',
  `abreviacao` varchar(30) DEFAULT NULL COMMENT 'descricao?Abreviação',
  `tipo` char(1) DEFAULT NULL COMMENT 'combo?Diretoria;Ministério',
  `tipo_comissao` char(1) DEFAULT NULL COMMENT 'combo?Estatutária;Outras*descricao?Tipo Comissão',
  `ordem` tinyint(4) DEFAULT NULL,
  `preencher` varchar(2) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='Cargos*Cadastro de Cargos do sistema.';

/*Data for the table `cargos` */

insert  into `cargos`(`id`,`nome`,`descricao`,`abreviacao`,`tipo`,`tipo_comissao`,`ordem`,`preencher`,`user_id`,`created`,`modified`) values 
(1,'Presidente(a)','Dirige e supervisiona a administração da Igreja; convoca e preside Assembleias; Assina Atas; Abre, movimenta e encerra contas bancárias junto com o tesoureiro (a); Apresenta à Assembleia relatórios periódicos e anuais das atividades administrativas; Decide juntamente com a Diretoria passíveis de apreciação pela Assembleia; Zelar pelo cumprimento do Estatuto e Regimento Interno. Representar a Igreja judicial e extrajudicialmente; Ter acesso às reuniões de qualquer órgão como membro de ofício, conforme art. 20 do Estatuto.','Presidente','D','',101,'\r',NULL,NULL,NULL),
(2,'Vice-presidente(a)','Substitui o presidente nos seus impedimentos e ausências.','Vice-presidente','D','',102,'\r',NULL,NULL,NULL),
(3,'1º Secretário(a)','Lavra e assina as Atas das Assembleias Gerais e do Conselho Diretor; Organiza os arquivos, livros, cadastro de Rol de Membros da Igreja, conforme art. 22 do Estatuto.','1 Secretário(a)','D','',104,'-1',NULL,NULL,NULL),
(4,'2º Secretário(a)','Substitui o 1º Secretário (a) nos seus impedimentos e eventuais ausências.','2 Secretário(a)','D','',105,'-1',NULL,NULL,NULL),
(5,'1º Tesoureiro(a)','Recebe/escritura as contribuições financeiras e faz pagamentos autorizados pela igreja; Abre, movimenta e encerra contas bancárias, juntamente com o Presidente; Elabora e apresenta relatórios à Assembleia; Alerta sobre eventual indisponibilidade de caixa, dentre outras obrigações, conforme art. 24 do Estatuto.','1 Tesoureiro (a)','D','',107,'-1',NULL,NULL,NULL),
(6,'2º Tesoureiro(a)','Auxilia o 1º tesoureiro (a) na execução do seu trabalho e substituí-lo nos seus impedimentos e ausências.','2 Tesoureiro (a)','D','',108,'-1',NULL,NULL,NULL),
(7,'Membro Comissão Orçamento','Elabora a Proposta orçamentária anual.','Comissão Orçamento','','E',112,'0\r',NULL,NULL,NULL),
(8,'Membro Conselho Fiscal','Examina e realiza parecer sobre os balancetes mensais e anuais elaborados pela tesouraria; acompanha a evolução financeira e o registro contábil. Examina periodicamente os relatórios financeiros, os lançamentos das contas da Igreja e recolhimentos legais, oferecendo parecer para apreciação da Assembleia. Recomenda medidas administrativas para a manutenção do equilíbrio financeiro à luz do orçamento anual.  Obs: Este Conselho é composto por 5 (cinco) Membros da Igreja, de preferência com habilidade técnica, conf. art. 29 do Estatuto.','Conselho Fiscal','D','',110,'0\r',NULL,NULL,NULL),
(9,'Ministério Evangelismo & Missões','Mobiliza e capacita a igreja para ações que promovam a expansão do Reino de Deus, através da obra missionária e evangelizadora. Responsabiliza-se pelo uso/conservação dos materiais dessa área na Igreja.','Evangelismo & Missões','M','',124,'\r',NULL,NULL,NULL),
(10,'Ministério de Ensino','Coordena o andamento da Escola Bíblica Dominical (EBD), seleciona e orienta os professores; Define material de estudos; Cria oportunidades e acompanha atividades que estimule o ensino bíblico. Responsabiliza-se pelo uso/conservação dos materiais dessa área na Igreja.','EBD','M','',122,'\r',NULL,NULL,NULL),
(11,'Ministério Núcleos de Vida','Coordena o trabalho dos Núcleos de Vida. Cria oportunidades de comunhão e integração de novos Membros.','Núcleos de Vida','M','',127,'\r',NULL,NULL,NULL),
(12,'Ministério Comunitário Cristão','Coordena e organiza, juntamente com sua equipe, cursos artesanais, informática, eletricista e outros, acompanhados de uma reflexão na palavra para a Igreja e Comunidade. Responsabiliza-se pelo uso/conservação dos materiais dessa área na Igreja.','MCC','M','',119,'\r',NULL,NULL,NULL),
(13,'Ministério de Infantil','Coordena e desenvolve juntamente com sua equipe o Culto Infantil, Berçário, Classes de EBD; Eventos especiais; Seleção de materiais adequados à faixa etária; Promoção de treinamento aos professores desse Ministério. Responsabiliza-se pelo uso/conservação dos equipamentos (material educativo, TV, Vídeos, etc) dessa área na Igreja.','Infantil','M','',125,'\r',NULL,NULL,NULL),
(14,'Ministério de Adolescentes','Coordena e organiza atividades de meninos e meninas maior de 13 e menores de 18 anos, tais como: reuniões, estudos, acampamentos, etc, para estimular comunhão, a amizade, edificação espiritual, serviço ao reino de Deus e a consciência da moral cristã, ajudando-o nas decisões pessoais ao lado de Cristo.','Adolescentes','M','',114,'0\r',NULL,NULL,NULL),
(15,'Ministério de Jovens','Coordena e organiza atividades juntamente com sua equipe para a faixa etária de 18 a 35 anos, tais como: reuniões, estudos, acampamentos, etc, para envolver os jovens em atividades que promovam a amizade, edificação espiritual, serviço ao reino de Deus e a consciência da moral cristã, visando à formação de crentes maduros e cidadãos conscientes e responsáveis.','Jovens','M','',126,'\r',NULL,NULL,NULL),
(16,'Ministério Embaixadores do Rei','Coordena e organiza atividades para meninos de 9 a 16 anos em atividades tais como: reuniões, estudos, acampamentos, etc, com o objetivo de desenvolver o caráter cristão, promover a amizade, edificação espiritual, serviço ao reino de Deus e a consciência moral, visando à formação de \"Homens de Valor\".','Embaixadores do Rei','M','',121,'\r',NULL,NULL,NULL),
(17,'Ministério de Casais','Coordena e organiza atividades para casais em encontros que promovam a valorização da relação conjugal e o companheirismo cristão, com objetivo do fortalecimento e desenvolvimento da família cristã.','Casais','M','',117,'0\r',NULL,NULL,NULL),
(18,'Ministério Celebrando a Vida','Coordena e organiza atividades para adultos com idade acima de 60 anos, tais como: reuniões, estudos, encontros que promovam companheirismo, crescimento cristão, evangelização e valorização da vida.','Celebrando a Vida','M','',118,'0\r',NULL,NULL,NULL),
(19,'Ministério de Mulheres','Coordena e organiza atividades para as mulheres da igreja de qualquer idade, onde elas sejam valorizadas, preparadas e desafiadas a viver de maneira plena seus dons e talentos para a glória de Deus.','Mulheres','M','',127,'\r',NULL,NULL,NULL),
(20,'Ministério de Sociabilidade','Coordena e organiza eventos que envolvam toda a igreja, com objetivo de promover a sociabilidade entre os membros, bem como apoia outros ministérios em suas programações sociais.','Sociabilidade','M','',127,'0\r',NULL,NULL,NULL),
(21,'Ministério de Cantina','Coordena e organiza eventos que são realizados na cantina, viabilizando seu uso de forma que os outros Ministérios possam fazer suas atividades sob sua orientação e apoio. Inclusive organiza as escalas de seu uso. Mantém o material/utensílios sob seu controle. Responsabiliza-se pelo uso/conservação dos equipamentos dessa área na Igreja.','Cantina','M','',116,'0\r',NULL,NULL,NULL),
(24,'Ministério de Música','Coordena e organiza as atividades musicais na Igreja, descobrindo talentos e incentivando pessoas a participar de coros, equipe de cânticos e regência; montando escalas para os cultos e apoiar outros ministérios em suas atividades; indicando e provendo cursos na área da música. Responsabiliza-se pelo uso/conservação dos equipamentos de música da Igreja.','Música','M','',127,'\r',NULL,NULL,NULL),
(25,'Ministério de Som','Gerenciar e operacionalizar a sonorização nos cultos, bem como manter a escala de operação e apoiar/orientar os Ministérios em suas atividades. Responsabiliza-se pelo uso/conservação dos equipamentos de som da Igreja.','Som','M','',127,'\r',NULL,NULL,NULL),
(26,'Ministério de Recepção','Coordena e organiza o trabalho das equipes de recepção nos cultos dominicais e eventos especiais, oferecendo oportunidade aos membros para servir nesse ministério, bem como montar as escalas de trabalho.','Recepção','M','',127,'0\r',NULL,NULL,NULL),
(27,'Ministério de Segurança','Coordena e organiza, juntamente com sua equipe, o trabalho e escala de segurança do ambiente externo da igreja, durante os cultos e demais atividades dos Ministérios se houver necessidade.','Segurança','M','',127,'\r',NULL,NULL,NULL),
(28,'Ministério de Decoração','Coordena e organiza, juntamente com sua equipe, a ornamentação de arranjos florais, toalhas, tapetes, etc, para o templo e demais ambientes da igreja, oferecendo apoio aos demais Ministérios em suas atividades. Responsabiliza-se pelo uso/conservação dos materiais dessa área da Igreja.','Decoração','M','',120,'\r',NULL,NULL,NULL),
(29,'Ministério de Esportes','Promove comunhão e evangelização através do esporte. Responsabiliza-se pelo uso/conservação dos materiais dessa área da Igreja.','Esportes','M','',123,'\r',NULL,NULL,NULL),
(30,'Assessoria Jurídica','Ser um órgão assessor para as questões jurídicas que envolvam a igreja.','Jurídico','M','',113,'\r',NULL,NULL,NULL),
(31,'Ministério de Patrimônio','Gerencia o patrimônio da igreja, móveis e imóveis, de maneira que estejam sempre bem documentados e preparados para o uso da Igreja.','Patrimônio','M','',127,'\r',NULL,NULL,NULL),
(33,'Professor(a) de EBD','','Professor de EBD','','',127,'\r',NULL,NULL,NULL),
(34,'Professor(a) de Crianças','','Professor de Crianças','','',127,'\r',NULL,NULL,NULL),
(35,'Pastor Titular','','Pastor Titular','','',127,'\r',NULL,NULL,NULL),
(36,'Membro Comissão Eleitoral','','Comissão Eleitoral','','O',127,'\r',NULL,NULL,NULL),
(37,'Diácono(iza)','','Diácono','','O',127,'\r',NULL,NULL,NULL),
(38,'Líder dos Diáconos','','Líder dos Diáconos','','',127,'\r',NULL,NULL,NULL),
(39,'Suplente Vice-Presidente(a)','Substituir o Vice-Presidente quando este substituir o Presidente.','Suplente do Vice-Presidente','D','',103,'0\r',NULL,NULL,NULL),
(40,'Vogal do Conselho Diretor','Vogal: É um membro comum da igreja que participa e vota no Conselho Diretor, não pode ocupar qualquer cargo de liderança.','Vogal','','E',111,'0\r',NULL,NULL,NULL),
(41,'Suplente 2º Tesoureiro(a)','Substitui o 2º tesoureiro(a), quando este substituir o 1º tesoureiro e ajudar na contagem dos dízimos e ofertas 1 vez por semana.','Suplente 2º Tesoureiro(a)','D','',109,'\r',NULL,NULL,NULL),
(42,'Ministério da Comunicação','Gerencia e operacionaliza a divulgação do culto e atividades da igreja por meio de registro de fotos e filmagens, projeção de slides e a transmissão do culto, bem como controla e organiza escalas de trabalho para apoiar os outros Ministérios em seus eventos. Se responsabilizar pelo uso/conservação dos equipamentos dessa área na Igreja.','Comunicação','M','E',115,'\r',NULL,NULL,NULL),
(43,'Suplente 2º Secretário(a)','Substitui o 2º Secretário(a), quando este substituir o 1º Secretário.','Suplente 2º Secretário(a)','D','',106,'0\r',NULL,NULL,NULL),
(44,'Líder de Núcleo','','Líder de Núcleo','','',0,'\r',NULL,NULL,NULL),
(45,'Conselheira da MR','','Conselheira da MR','','O',0,'\r',NULL,NULL,NULL);

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

/*Data for the table `categorias` */

insert  into `categorias`(`id`,`nome`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'teste',1,4,'2017-07-07 08:20:00','2017-07-07 08:20:00');

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

/*Data for the table `categorias_financeira` */

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

/*Data for the table `contas_financeira` */

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

/*Data for the table `contatos` */

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1,
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Departamentos*Cadastro Departamentos';

/*Data for the table `departamentos` */

insert  into `departamentos`(`id`,`nome`,`descricao`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'teste','asdfasdfasdfsdaf\nasdf\nasdf\n\nasdfasdfasdfasdfsad',1,1,'2017-07-13 16:23:00','2017-07-13 16:23:00');

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

/*Data for the table `dons` */

insert  into `dons`(`id`,`nome`,`observacoes`,`user_id`,`empresa_id`,`created`,`modified`) values 
(1,'Palavra de Ciência ou Conhecimento','Este dom é a revelação de um fato que está acontecendo ou que já aconteceu. Também esta revelação pode ser dada em visão ou em sonho ou mediante uma voz.',1,1,'2017-07-07 08:24:00','2017-08-22 18:44:00'),
(2,'Palavra de Sabedoria','Este dom é uma palavra, uma proclamação, uma declaração de sabedoria dada por Deus através da revelação do Espírito Santo, para satisfazer a necessidade de solução urgente de um problema em particular.',1,1,'2017-08-22 18:33:00','2017-08-22 18:33:00'),
(3,'Discernimento de Espírito','Através deste dom, Deus revela ao crente, a fonte e o propósito de tudo e qualquer forma de poder espiritual \"E isto fez ele por muitos dias. Mas Paulo, pertubado, voltou-se e disse ao espírito: em nome de Jesus Cristo, te mando que saias dela. E, na mesma hora, saiu.\" (At 16.18).',1,1,'2017-08-22 18:34:00','2017-08-22 18:34:00'),
(4,'Dons de Curar','No grego, tanto o dom (curar), como o seu efeito, está no plural, o que dá a entender que existe uma variedades de modos na operação deste dom. \"E aconteceu estar de cama enfermo de febre e disenteria o pai de Públio, que Paulo foi ver, e, havendo orado, pôs as mãos sobre ele, e o curou.\" (At 28.8)',1,1,'2017-08-22 18:34:00','2017-08-22 18:34:00'),
(5,'Operação de Milagres','Por milagres ou maravilhas, entende-se tudo ou qualquer fenômeno que altera uma lei divina conhecida e pré-estabelecida. Milagres e maravilhas são plurais da palavra poder em Atos 1.8 \"Mas recebereis a virtude do Espírito Santo, que há de vir sobre vós; e ser-me-eis testemunhas, tanto em Jerusalém como em toda a Judéia e Samaria, e até aos confins da terra.\" e significa: Atos de Poder Glorioso, sobrenaturais, que vão além do que o homem pode ver. \"Mas ele, pegando-lhe na mão, clamou dizendo: Levanta-te menina!\" Lc 8.54',1,1,'2017-08-22 18:34:00','2017-08-22 18:34:00'),
(6,'Dom da Fé','Este dom envolve uma fé especial, diferente da fé para salvação, ou da fé que é mostrada por Paulo como aspecto do fruto do Espírito \"Mas o fruto do Espírito é: amor, gozo, paz, longanimidade, benignidade, bondade, fé, mansidão, temperança.\" [Gl 5.22]. O dom da fé traduz uma fé especial e sobrenatural, verdadeiro apelo a Deus no sentido de que ele intervenha quando todos os recursos humanos se têm esgotado [Hebreus 11].',1,1,'2017-08-22 18:35:00','2017-08-22 18:35:00'),
(7,'Variedade de Línguas','Variedade de línguas e a expressão falada e sobrenatural duma língua nunca estudada pela pessoa que fala uma palavra enunciada pelo espírito santo, não compreendida por quem fala.',1,1,'2017-08-22 18:35:00','2017-08-22 18:35:00'),
(8,'Interpretação das Línguas','O dom de interpretação das línguas é o único dom cuja existência ou função depende doutro dom, variedade de línguas.',1,1,'2017-08-22 18:35:00','2017-08-22 18:35:00'),
(9,'Profecia','A profecia é uma manifestação do Espírito de Deus e não da mente do homem, e é concedida a cada um usando um fim proveitoso \"Mas a manifestação do Espírito é dada a cada um, para o que for útil.\" [1 Co 12.7].',1,1,'2017-08-22 18:35:00','2017-08-22 18:35:00');

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

/*Data for the table `editoras` */

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET latin1 NOT NULL,
  `cnpj` varchar(14) CHARACTER SET latin1 NOT NULL,
  `telefone` varchar(15) CHARACTER SET latin1 NOT NULL,
  `endereco` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `numero` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `complemento` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `uf` varchar(2) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `matriz_id` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `subdomain` varchar(15) CHARACTER SET latin1 DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Igrejas*Cadastro das igrejas no sistema. ';

/*Data for the table `empresas` */

insert  into `empresas`(`id`,`nome`,`cnpj`,`telefone`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`uf`,`email`,`matriz_id`,`tipo`,`subdomain`) values 
(1,'Primeira Igreja Batista','99999999999999','1432323335','Rua Araujo Leite','20','Quadra 2','Centro','Bauru','SP','pib@pib.com.br',NULL,1,'pibb'),
(2,'Igreja Batista Estoril','00000000000000','1431084054','Rua Virgilio Malta','10','15','Jd Estoril','Bauru','SP','ibe@ibe.com.br',NULL,1,'ibe');

/*Table structure for table `enderecos` */

DROP TABLE IF EXISTS `enderecos`;

CREATE TABLE `enderecos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(70) CHARACTER SET latin1 NOT NULL,
  `numero` varchar(10) CHARACTER SET latin1 NOT NULL,
  `complemento` varchar(70) CHARACTER SET latin1 DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET latin1 NOT NULL,
  `cep` varchar(10) CHARACTER SET latin1 NOT NULL,
  `cidade` varchar(100) CHARACTER SET latin1 NOT NULL,
  `estado_id` int(11) unsigned NOT NULL COMMENT 'relaciona?estados:id;sigla',
  `membro_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?membros:id;nome',
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `empresa_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_enderecos_has_estados` (`estado_id`),
  KEY `fk_enderecos_has_membros` (`membro_id`),
  CONSTRAINT `fk_enderecos_has_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_enderecos_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Endereços*Cadastro Endereços';

/*Data for the table `enderecos` */

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

/*Data for the table `escolaridades` */

insert  into `escolaridades`(`id`,`descricao`,`obs`,`user_id`,`created`,`modified`) values 
(1,'Pós Graduação','Especialização',1,'2017-08-10 22:13:00','2017-08-10 22:13:00'),
(2,'MBA','Especialização MBA',1,'2017-08-10 22:13:00','2017-08-10 22:13:00'),
(3,'Ensino Fundamental','Ensino fundamental da primeira à nona série.',1,'2017-08-10 22:14:00','2017-08-10 22:14:00'),
(4,'Ensino Médio','Ensino médio do primeiro ao terceiro ano.',1,'2017-08-10 22:15:00','2017-08-10 22:15:00'),
(5,'Ensino Técnico','Ensino técnico.',1,'2017-08-10 22:15:00','2017-08-10 22:15:00'),
(6,'Superior Completo','Concluído curso de graduação.',1,'2017-08-10 22:15:00','2017-08-10 22:15:00'),
(7,'Superior Incompleto','Curso de graduação não concluído.',1,'2017-08-10 22:16:00','2017-08-10 22:16:00'),
(8,'Sem Instrução','Sem instrução formal.',1,'2017-08-12 23:50:00','2017-08-12 23:53:00'),
(9,'Mestrado','Nível de mestrado.',1,'2017-08-12 23:52:00','2017-08-12 23:52:00'),
(10,'Doutorado','Nível de doutorado.',1,'2017-08-12 23:52:00','2017-08-12 23:52:00'),
(11,'Pós Doutorado','Nível de pós doutorado.',1,'2017-08-12 23:53:00','2017-08-12 23:53:00'),
(12,'Livre Docente','Nível de livre docência.',1,'2017-08-12 23:54:00','2017-08-12 23:54:00');

/*Table structure for table `estados` */

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sigla` varchar(2) NOT NULL,
  `codibge` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Estados*Tabela com código, sigla e nome dos estados do Brasil';

/*Data for the table `estados` */

insert  into `estados`(`id`,`sigla`,`codibge`,`nome`) values 
(1,'AP',16,'Amapá'),
(2,'AM',13,'Amazonas'),
(3,'BA',29,'Bahia'),
(4,'CE',23,'Ceará'),
(5,'DF',53,'Distrito Federal'),
(6,'ES',32,'Espírito Santo'),
(7,'GO',52,'Goiás'),
(8,'MA',21,'Maranhão'),
(9,'MT',51,'Mato Grosso'),
(10,'MS',50,'Mato Grosso do Sul'),
(11,'MG',31,'Minas Gerais'),
(12,'PA',15,'Pará'),
(13,'PB',25,'Paraíba'),
(14,'PR',41,'Paraná'),
(15,'PE',26,'Pernambuco'),
(16,'PI',22,'Piauí'),
(17,'RJ',33,'Rio de Janeiro'),
(18,'RN',24,'Rio Grande do Norte'),
(19,'RS',43,'Rio Grande do Sul'),
(20,'RO',11,'Rondônia'),
(21,'RR',14,'Roraima'),
(22,'SC',42,'Santa Catarina'),
(23,'SP',35,'São Paulo'),
(24,'SE',28,'Sergipe'),
(25,'TO',17,'Tocantins');

/*Table structure for table `fornecedores` */

DROP TABLE IF EXISTS `fornecedores`;

CREATE TABLE `fornecedores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome_fantasia` varchar(150) NOT NULL,
  `razao_social` varchar(150) NOT NULL,
  `cnpj` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `telefone2` varchar(11) DEFAULT NULL,
  `estado_id` int(10) unsigned DEFAULT NULL COMMENT 'relaciona?estados:id;sigla',
  `cidade` varchar(100) DEFAULT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `tipo` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_fornecedores_has_estado` (`estado_id`),
  KEY `fk_fornecedores_has_tipo` (`tipo`),
  CONSTRAINT `fk_fornecedores_has_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_has_tipo` FOREIGN KEY (`tipo`) REFERENCES `tipo_fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `fornecedores` */

insert  into `fornecedores`(`id`,`nome_fantasia`,`razao_social`,`cnpj`,`email`,`telefone`,`telefone2`,`estado_id`,`cidade`,`logradouro`,`complemento`,`cep`,`tipo`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'IT V&C - INFORMÁTICA','','','','1597071212',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),
(2,'Dell','','','','',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),
(3,'Itajobi Fogões','','','','',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),
(4,'Supermercado Confiança','','53045266000974','','',NULL,NULL,NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),
(5,'Pernambucanas','','','','',NULL,NULL,NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),
(6,'Doctor Informática V&C - INFORMÁTICA','','','','1430188808',NULL,NULL,NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),
(7,'Alargêmeos - Alarmes e Portões','','','alargemeos@alargemeos.com.br','1432275400',NULL,NULL,NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),
(8,'Só Fogões Assistência Técnica','','','','1432243330',NULL,NULL,NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),
(9,'Art Clima Ar Condicionado, Ar Condicionado','','','','1432141956',NULL,NULL,NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL);

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

/*Data for the table `grupos_financeiro` */

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

/*Data for the table `itens` */

/*Table structure for table `membros` */

DROP TABLE IF EXISTS `membros`;

CREATE TABLE `membros` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ativo` int(11) NOT NULL DEFAULT '1',
  `nome` varchar(100) CHARACTER SET latin1 NOT NULL,
  `sexo` char(1) DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `naturalidade` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `estado_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?estados:id;sigla',
  `estadocivil` tinyint(10) unsigned DEFAULT NULL,
  `latitude` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `rg` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `cpf` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `fone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `cel` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `escolaridade_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?escolaridades:id;descricao',
  `profissao_id` int(11) unsigned DEFAULT NULL COMMENT 'relaciona?profissoes:id;nome',
  `empresa` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `databatismo` date DEFAULT NULL,
  `igrejabatismo` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `pastorbatismo` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `ultimaigreja` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `datamembro` date DEFAULT NULL,
  `igrejasanteriores` text CHARACTER SET latin1,
  `cargo_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) NOT NULL COMMENT 'oculto',
  `user_id` int(11) NOT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  `tipo` char(1) CHARACTER SET latin1 DEFAULT NULL COMMENT 'combo?Membro;Visitante',
  `membros_ft` text COMMENT 'oculto',
  PRIMARY KEY (`id`),
  KEY `fk_membros_has_estados` (`estado_id`),
  KEY `fk_membros_has_escolaridades` (`escolaridade_id`),
  KEY `fk_membros_has_profissoes` (`profissao_id`),
  FULLTEXT KEY `membros_ft` (`membros_ft`),
  CONSTRAINT `fk_membros_has_escolaridades` FOREIGN KEY (`escolaridade_id`) REFERENCES `escolaridades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_membros_has_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_membros_has_profissoes` FOREIGN KEY (`profissao_id`) REFERENCES `profissoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Membros*Cadastro de membros';

/*Data for the table `membros` */

insert  into `membros`(`id`,`ativo`,`nome`,`sexo`,`datanascimento`,`naturalidade`,`estado_id`,`estadocivil`,`latitude`,`longitude`,`rg`,`cpf`,`email`,`fone`,`cel`,`escolaridade_id`,`profissao_id`,`empresa`,`databatismo`,`igrejabatismo`,`pastorbatismo`,`ultimaigreja`,`datamembro`,`igrejasanteriores`,`cargo_id`,`empresa_id`,`user_id`,`created`,`modified`,`tipo`,`membros_ft`) values 
(1,1,'Filipe Alves Vieira','M','1982-11-22','São Paulo',23,2,NULL,NULL,'331913574','29446304822','fialvieira@gmail.com','1432267258','14997026905',2,1,'ECT','1983-02-15','XIS','João da Silva','Ipsolon','2017-08-12','X, Y, Z.',5,1,1,'2017-08-12 11:58:00','2017-08-13 00:30:00','M','Filipe Alves Vieira 22/11/1982 331913574 29446304822 fialvieira@gmail.com 1432267258 14997026905 15/02/1983 XIS João da Silva Ipsolon 12/08/2017 X, Y, Z.'),
(2,0,'Jair Rodrigues de Freitas','M','1960-02-15','Cuiabá',10,2,NULL,NULL,'4449823764','33333333333','jfrodrigues@chefe.com.br','1432245578','14996782244',1,1,'ECT','1961-09-15','XXZ','João da Silva','YYZ','2017-08-13','YYZ.',NULL,1,1,'2017-08-13 00:50:00','2017-08-13 00:50:00','M',NULL);

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

/*Data for the table `movimentacao_bens` */

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

/*Data for the table `movimentacao_itens` */

/*Table structure for table `movimentacaoatas` */

DROP TABLE IF EXISTS `movimentacaoatas`;

CREATE TABLE `movimentacaoatas` (
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
  CONSTRAINT `fk_movimentacaoatas_has_cargos` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimentacaoatas_has_membros` FOREIGN KEY (`membro_id`) REFERENCES `membros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Armazena a movimentação de cargos de acordo com as atas lanç';

/*Data for the table `movimentacaoatas` */

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
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COMMENT='Pastores*Cadastro de pastor';

/*Data for the table `pastores` */

insert  into `pastores`(`id`,`nome`,`tratamento`,`sec_atual`,`user_id`,`created`,`modified`) values 
(1,'Jeferson Rodolfo Cristianni','Pr\r',NULL,NULL,NULL,NULL),
(2,'Samuel Biassi do Nascimento','Pr\r',NULL,NULL,NULL,NULL),
(3,'Onésimo Pereira do Nascimento Filho','Pr\r',NULL,NULL,NULL,NULL),
(4,'Helio Dorta','Pr\r',NULL,NULL,NULL,NULL),
(5,'Demétrio Fraiha','Pr\r',NULL,NULL,NULL,NULL),
(6,'Moacir B. de Albuquerque','Pr\r',NULL,NULL,NULL,NULL),
(7,'Paulo Coelho','Pr\r',NULL,NULL,NULL,NULL),
(8,'José Benjamin da Silva','Pr\r',NULL,NULL,NULL,NULL),
(9,'Rubin Slobodticov','Pr\r',NULL,NULL,NULL,NULL),
(10,'Renato Cobra Castino','Pr\r',NULL,NULL,NULL,NULL),
(11,'Oscar  Fernandes Berling','Pr\r',NULL,NULL,NULL,NULL),
(12,'Antônio Carlos','Pr\r',NULL,NULL,NULL,NULL),
(13,'Márcio Teixeira Monteiro','Pr\r',NULL,NULL,NULL,NULL),
(14,'Jeremias Clarindo Gomes','Pr\r',NULL,NULL,NULL,NULL),
(15,'Anastácio José da Silva','Pr\r',NULL,NULL,NULL,NULL),
(16,'Carlos Henrique Castanheira','Pr\r',NULL,NULL,NULL,NULL),
(17,'Paulo Moreira','Pr\r',NULL,NULL,NULL,NULL),
(18,'Isaltino Gomes Coelho Filho','Pr\r',NULL,NULL,NULL,NULL),
(19,'Frederico Vitols','Pr\r',NULL,NULL,NULL,NULL),
(20,'José de Souza','Pr\r',NULL,NULL,NULL,NULL),
(21,'Jamil Nassar','Pr\r',NULL,NULL,NULL,NULL),
(22,'Luiz Zosazi Fernandes','Pr\r',NULL,NULL,NULL,NULL),
(23,'Paul Stouffer','Pr\r',NULL,NULL,NULL,NULL),
(24,'Ivars Bember','Pr\r',NULL,NULL,NULL,NULL),
(25,'Luiz Carlos Cavareto','Pr\r',NULL,NULL,NULL,NULL),
(26,'João Bispo','Pr\r',NULL,NULL,NULL,NULL),
(27,'José Geraldo de Araújo','Pr\r',NULL,NULL,NULL,NULL),
(28,'Williams Balaniuc Filho','Pr\r',NULL,NULL,NULL,NULL),
(29,'Abdoral Henrique de Araujo','Pr.\r',NULL,NULL,NULL,NULL),
(30,'Syllas Hernandes','Pr\r',NULL,NULL,NULL,NULL),
(31,'Milton de Azevedo Neto','Pr\r',NULL,NULL,NULL,NULL),
(32,'Ézer Belo das Chagas','Pr\r',NULL,NULL,NULL,NULL),
(33,'Joel Ferreira da Silva','Pr\r',NULL,NULL,NULL,NULL),
(34,'Jonas B. Lima','Pr\r',NULL,NULL,NULL,NULL),
(35,'Onésimo Nunes Lima','Pr\r',NULL,NULL,NULL,NULL),
(36,'Eber Vasconcelos','Pr\r',NULL,NULL,NULL,NULL),
(37,'Walter de Matos Correia','Pr\r',NULL,NULL,NULL,NULL),
(38,'Geraldo Marcondes','Presbítero\r',NULL,NULL,NULL,NULL),
(39,'Arlindo','Pr\r',NULL,NULL,NULL,NULL),
(40,'Jair Salgueiro','Pr\r',NULL,NULL,NULL,NULL),
(41,'Nelson Pacheco','Pr\r',NULL,NULL,NULL,NULL),
(42,'Francisco Cid','Pr\r',NULL,NULL,NULL,NULL),
(43,'Fernando','Pr\r',NULL,NULL,NULL,NULL),
(44,'Fausto Vasconselos','Pr\r',NULL,NULL,NULL,NULL),
(45,'Domingos Jardim','Pr\r',NULL,NULL,NULL,NULL),
(46,'Valtencir','Pr\r',NULL,NULL,NULL,NULL),
(47,'Alfredo Carlstrom','Pr\r',NULL,NULL,NULL,NULL),
(48,'Edison Vicente','Pr\r',NULL,NULL,NULL,NULL),
(49,'José Carlos Coine','Pr\r',NULL,NULL,NULL,NULL),
(50,'Ulisses S. S. Filho','Pr\r',NULL,NULL,NULL,NULL),
(51,'Ismael de Almeida Claro','Pr\r',NULL,NULL,NULL,NULL),
(52,'Mauricio Aparecido Theodoro Souza','Pr\r',NULL,NULL,NULL,NULL),
(53,'José da Silva','Pr\r',NULL,NULL,NULL,NULL),
(54,'Laimon Bember','Pr\r',NULL,NULL,NULL,NULL),
(55,'Dorival Bosso','Pr\r',NULL,NULL,NULL,NULL),
(56,'Marcelo Madeira','Pr\r',NULL,NULL,NULL,NULL),
(57,'Paulo Eduardo Gomes Vieira','Pr\r',NULL,NULL,NULL,NULL),
(58,'Nelson Leomar Gener','Pr\r',NULL,NULL,NULL,NULL),
(59,'Adilson','Pr\r',NULL,NULL,NULL,NULL),
(60,'Alcides Velasco','Pr\r',NULL,NULL,NULL,NULL),
(61,'José Miguel João','Pr\r',NULL,NULL,NULL,NULL),
(62,'Jacob Ricardo Inke','Pr\r',NULL,NULL,NULL,NULL),
(63,'Marta Reis','Missionári\r',NULL,NULL,NULL,NULL),
(64,'Calé','Pr\r',NULL,NULL,NULL,NULL),
(65,'Jorge Prado','Pr\r',NULL,NULL,NULL,NULL),
(66,'Carlos Walter','Pr\r',NULL,NULL,NULL,NULL),
(67,'Maciel Parente','Pr\r',NULL,NULL,NULL,NULL),
(68,'Peres','Pr\r',NULL,NULL,NULL,NULL),
(69,'Humberto Viegas','Pr\r',NULL,NULL,NULL,NULL),
(70,'Cláudio','Pr\r',NULL,NULL,NULL,NULL),
(71,'Nivaldo Nassiff','Pr\r',NULL,NULL,NULL,NULL),
(72,'Renata','Pra.\r',NULL,NULL,NULL,NULL),
(73,'Rodolfo Lira do Rêgo','Pr\r',NULL,NULL,NULL,NULL),
(74,'Renato Guimarães','Pr\r',NULL,NULL,NULL,NULL),
(75,'Arthur Heder','Pr\r',NULL,NULL,NULL,NULL),
(76,'João Gregoris','Pr\r',NULL,NULL,NULL,NULL),
(77,'Ney','Pr\r',NULL,NULL,NULL,NULL),
(78,'Manoel Rodrigues de Lima','Pr\r',NULL,NULL,NULL,NULL),
(79,'Ismael Alves P. Filho','Pr\r',NULL,NULL,NULL,NULL),
(80,'Carlos Jaquelo','Pr\r',NULL,NULL,NULL,NULL),
(81,'Cleberson Kauffman Bigarani','Pr\r',NULL,NULL,NULL,NULL),
(82,'Hilton','Pr\r',NULL,NULL,NULL,NULL),
(83,'Ivan Freitas','Pr\r',NULL,NULL,NULL,NULL),
(84,'Pedro Souza Brandão','Pr\r',NULL,NULL,NULL,NULL),
(85,'Darcy Mendonça','Pr\r',NULL,NULL,NULL,NULL),
(86,'Robson de Melo Chaves','Pr\r',NULL,NULL,NULL,NULL),
(87,'Fabio Grigorico','Pr\r',NULL,NULL,NULL,NULL),
(88,'Antônio Nogueira Coelho','Pr\r',NULL,NULL,NULL,NULL),
(89,'Abner','Pr\r',NULL,NULL,NULL,NULL),
(90,'Antônio Oliveira','Pr\r',NULL,NULL,NULL,NULL),
(91,'Joelcio Barreto','Pr\r',NULL,NULL,NULL,NULL),
(92,'Thurmon Briant','Pr\r',NULL,NULL,NULL,NULL),
(93,'Messias','Pr\r',NULL,NULL,NULL,NULL),
(94,'Celso Nascimento','Pr\r',NULL,NULL,NULL,NULL),
(95,'Salvador Farina Filho','Pr\r',NULL,NULL,NULL,NULL),
(96,'Glenio F. Paranaguá','Pr\r',NULL,NULL,NULL,NULL),
(97,'Victor Azevedo','Pr\r',NULL,NULL,NULL,NULL),
(98,'Antonio Lopes','Pr\r',NULL,NULL,NULL,NULL),
(99,'Carlos Roberto Cunha','Pr\r',NULL,NULL,NULL,NULL),
(100,'Ciro Costa e Silva','Pr\r',NULL,NULL,NULL,NULL),
(101,'Zacarias Ferreira Lima','Pr\r',NULL,NULL,NULL,NULL),
(102,'Zacarias de Aguiar Severo','Pr\r',NULL,NULL,NULL,NULL),
(103,'Viana','Pr\r',NULL,NULL,NULL,NULL),
(104,'Souza','Pr\r',NULL,NULL,NULL,NULL),
(105,'Francisco Benedito de Souza','Pr\r',NULL,NULL,NULL,NULL),
(106,'Lima','Pr\r',NULL,NULL,NULL,NULL),
(108,'Antonio Carlos Cabral','Pr\r',NULL,NULL,NULL,NULL),
(109,'Marcos Pinto','Pr\r',NULL,NULL,NULL,NULL),
(110,'Jesse Murphi','Pr\r',NULL,NULL,NULL,NULL),
(111,'Samuel Chagas','Pr\r',NULL,NULL,NULL,NULL),
(112,'Almir Araújo Dias','Pr\r',NULL,NULL,NULL,NULL),
(113,'Isaac S. da Silva','Pr\r',NULL,NULL,NULL,NULL),
(114,'Francisco Jaildo Santana','Pr\r',NULL,NULL,NULL,NULL),
(115,'Otacílio','Pr\r',NULL,NULL,NULL,NULL),
(116,'Eucleme Lopes Paula','Pr\r',NULL,NULL,NULL,NULL),
(117,'Silverio Lucas Jr.','Pr\r',NULL,NULL,NULL,NULL),
(118,'Irineu Tenório Gomes','Pr\r',NULL,NULL,NULL,NULL),
(119,'Gunther Carlos de Oliveira','Pr\r',NULL,NULL,NULL,NULL),
(120,'Luiz Soares','Missionári\r',NULL,NULL,NULL,NULL),
(121,'Diogênes Ferreira Chagas','Pr\r',NULL,NULL,NULL,NULL),
(122,'Henrique Cirilo Correia','Pr\r',NULL,NULL,NULL,NULL),
(123,'Melquizedeque','Pr\r',NULL,NULL,NULL,NULL),
(124,'Sérgio Moura','Pr\r',NULL,NULL,NULL,NULL),
(125,'Antonio Abuchain','Pr\r',NULL,NULL,NULL,NULL),
(126,'Moacir','Pr\r',NULL,NULL,NULL,NULL),
(127,'Edson Borges de Aquino','Pr\r',NULL,NULL,NULL,NULL),
(128,'Joao Duduch','Pr\r',NULL,NULL,NULL,NULL),
(129,'Nilsom Rodrigues Costa','Pr\r',NULL,NULL,NULL,NULL),
(130,'Guilhermino dos Santos','Pr\r',NULL,NULL,NULL,NULL),
(131,'Mario Doro','Pr\r',NULL,NULL,NULL,NULL),
(132,'Adualdo','Pr\r',NULL,NULL,NULL,NULL),
(133,'Enio Latorre','Pr\r',NULL,NULL,NULL,NULL),
(134,'Hélio Rangel','Pr\r',NULL,NULL,NULL,NULL),
(135,'Irland de Azevedo','Pr\r',NULL,NULL,NULL,NULL),
(136,'João Carlos Flores','Pr\r',NULL,NULL,NULL,NULL),
(137,'Jairo Gonzaga','Pr\r',NULL,NULL,NULL,NULL),
(138,'Marcos Antônio P. de Paula','Pr\r',NULL,NULL,NULL,NULL),
(139,'Joanito Ambrósio','Pr\r',NULL,NULL,NULL,NULL),
(140,'João Gregório Urbieta','Pr\r',NULL,NULL,NULL,NULL),
(141,'Ismael Luiz dos Santos','Pr\r',NULL,NULL,NULL,NULL),
(142,'Cesar Lacerda Moura Campos','Pr\r',NULL,NULL,NULL,NULL),
(143,'Oswanil Alves','Pr\r',NULL,NULL,NULL,NULL),
(144,'Mario Perreira dos Santos','Pr\r',NULL,NULL,NULL,NULL),
(145,'Lourenço Maria Jacinto','Pr\r',NULL,NULL,NULL,NULL),
(146,'Jaziel Marsola','Pr\r',NULL,NULL,NULL,NULL),
(147,'Alfredo','Pr\r',NULL,NULL,NULL,NULL),
(148,'Douglas','Pr\r',NULL,NULL,NULL,NULL),
(149,'Hugo Eduardo Montes','Pr\r',NULL,NULL,NULL,NULL),
(150,'Abner Cerqueira','Pr\r',NULL,NULL,NULL,NULL),
(151,'José Peres Niquette','Pr\r',NULL,NULL,NULL,NULL),
(152,'Milton Azevedo Neto','Pr\r',NULL,NULL,NULL,NULL),
(153,'Hernandes','Pr\r',NULL,NULL,NULL,NULL),
(154,'Walter Frichenbruders','Pr\r',NULL,NULL,NULL,NULL),
(155,'Godoberto','Pr\r',NULL,NULL,NULL,NULL),
(156,'Orosino','Pr\r',NULL,NULL,NULL,NULL),
(157,'José Renato','Pr\r',NULL,NULL,NULL,NULL),
(159,'William Tenório Quintela','Pr\r',NULL,NULL,NULL,NULL),
(160,'Flávio Bini Bortolotti','Pr\r',NULL,NULL,NULL,NULL),
(161,'Eli Fernandes','Pr\r',NULL,NULL,NULL,NULL),
(162,'Irland Pereira de Azevedo','Pr. Dr.\r',NULL,NULL,NULL,NULL),
(163,'João Garcia Quintanilha Filho','Pr\r',NULL,NULL,NULL,NULL),
(164,'Gilmar','Pr\r',NULL,NULL,NULL,NULL),
(165,'Baltazar','Pr\r',NULL,NULL,NULL,NULL),
(166,'André Vargas','Pr\r',NULL,NULL,NULL,NULL),
(167,'Arídio P. Barreto','Pr\r',NULL,NULL,NULL,NULL),
(168,'Luiz Cruz','Pr\r',NULL,NULL,NULL,NULL),
(169,'Orlando Fenske','Pr\r',NULL,NULL,NULL,NULL),
(170,'Valteir Francisco Samuel Gomes','Pr\r',NULL,NULL,NULL,NULL),
(171,'Elias','Pr\r',NULL,NULL,NULL,NULL),
(172,'José Geraldo Dornelas','Pr\r',NULL,NULL,NULL,NULL),
(173,'José Furtado Mendonça','Pr\r',NULL,NULL,NULL,NULL),
(174,'Hugo Evandro Silveira','Pr\r',NULL,NULL,NULL,NULL),
(175,'Sillas Larghi Campos','Pr\r',NULL,NULL,NULL,NULL),
(176,'Hebert Soler','Pr\r',NULL,NULL,NULL,NULL),
(177,'Rubens','Pr\r',NULL,NULL,NULL,NULL),
(178,'Luis','Pr\r',NULL,NULL,NULL,NULL),
(179,'Paulo Eduardo Klawa','Pr\r',NULL,NULL,NULL,NULL),
(180,'Paulo, Pr','Pr\r',NULL,NULL,NULL,NULL),
(181,'João Batista Martins de Sá','Pr\r',NULL,NULL,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `pessoa_dons` */

insert  into `pessoa_dons`(`id`,`dom_id`,`membro_id`,`empresa_id`,`user_id`,`created`,`modified`) values 
(2,1,1,1,1,'2017-08-26 05:27:00','2017-08-26 05:27:00'),
(3,2,1,1,1,'2017-08-26 05:27:00','2017-08-26 05:27:00'),
(4,9,1,1,1,'2017-08-26 05:27:00','2017-08-26 05:27:00'),
(6,5,2,1,1,'2017-08-26 05:29:00','2017-08-26 05:29:00'),
(7,5,2,1,3,'2017-11-20 09:50:00','2017-11-20 09:50:00'),
(8,1,1,1,3,'2017-11-20 13:17:00','2017-11-20 13:17:00'),
(9,2,1,1,3,'2017-11-20 13:17:00','2017-11-20 13:17:00'),
(10,9,1,1,3,'2017-11-20 13:17:00','2017-11-20 13:17:00'),
(11,1,1,1,1,'2017-12-18 00:19:12','2017-12-18 00:19:12'),
(12,2,1,1,1,'2017-12-18 00:19:12','2017-12-18 00:19:12'),
(13,9,1,1,1,'2017-12-18 00:19:12','2017-12-18 00:19:12'),
(14,2,1,1,1,'2017-12-18 00:20:49','2017-12-18 00:20:49'),
(15,2,1,1,1,'2017-12-18 00:21:10','2017-12-18 00:21:10');

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

/*Data for the table `profissoes` */

insert  into `profissoes`(`id`,`nome`,`descricao`,`empresa_id`,`user_id`,`created`,`modified`) values 
(1,'Analista de sistemas','Profissional formado na área de TI.',1,1,'2017-08-11 00:56:00','2017-08-11 00:58:00'),
(2,'Vendedor','Qualquer área de vendas.',1,1,'2017-08-11 00:57:00','2017-08-11 00:57:00'),
(3,'Advogado','Profissional formado em direito.',1,1,'2017-08-11 00:57:00','2017-08-11 00:59:00'),
(4,'Administrador','Profissional formado em administração de empresas',1,1,'2017-08-11 00:58:00','2017-08-11 00:58:00');

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

/*Data for the table `relacionamentos` */

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

/*Data for the table `representante` */

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

/*Data for the table `tabelas_auto` */

insert  into `tabelas_auto`(`codigo`,`tabela`,`menu`,`descricao`,`perfil`) values 
(1,'cargos','Cadastros','Cargo','1,2,5'),
(2,'categorias','Cadastros','Categoria','1,2,5'),
(3,'dons','Cadastros','Dons','1,2,5'),
(4,'membros','Cadastros','Membros','1,2,5'),
(5,'escolaridades','Cadastros','Escolaridades','1,2,5'),
(6,'profissoes','Cadastros','Profissões','1,2,5');

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

/*Data for the table `tipo_bens` */

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

/*Data for the table `tipo_biblioteca` */

/*Table structure for table `tipo_fornecedores` */

DROP TABLE IF EXISTS `tipo_fornecedores`;

CREATE TABLE `tipo_fornecedores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'oculto',
  `created` datetime DEFAULT NULL COMMENT 'oculto',
  `modified` datetime DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Tipo de Fornecedores';

/*Data for the table `tipo_fornecedores` */

insert  into `tipo_fornecedores`(`id`,`descricao`,`user_id`,`created`,`modified`) values 
(1,'Fabricante',NULL,NULL,NULL),
(2,'Fornecedor',NULL,NULL,NULL),
(3,'Assitência Técnica',NULL,NULL,NULL);

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

/*Data for the table `tiporelacionamentos` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Todos os usuários do Sistema.';

/*Data for the table `users` */

insert  into `users`(`id`,`facebook_id`,`username`,`senha`,`nome`,`email`,`celular`,`cpf`,`created`,`modified`,`perfil`,`ativo`,`hash_id`,`users_ft`) values 
(1,NULL,'fialvieira','$2y$10$RxPikDKcHQP.YnTEW1Eq7uI7bb8a2V.k8KsCvHhrK3kvLQ2E2LEtS','Filipe Alves Vieira','fialvieira@gmail.com','14997026905','29446304822','2017-06-25 23:53:27','2017-06-25 23:53:27',1,'S',NULL,'fialvieira Filipe Alves Vieira fialvieira@gmail.com 14997026905 29446304822'),
(2,NULL,'admin','$2y$10$CBpVsHUiZGKaTzfWZQJeeuZfLdgaC4BwcsCPBuMDY25dkNgIr5qy6','admin','adm@pib.com.br',NULL,NULL,NULL,'2017-06-27 18:15:44',2,'S',NULL,'admin admin adm@pib.com.br  '),
(3,NULL,'lucas','$2y$10$9Or9lpxseUmy40wXIAdl3OitNLETvktTmUv7AUl3PHsscYsDsWn2u','Lucas Silva e Silva','lu@cas.com.br','14997456672','99999999999',NULL,'2017-06-27 19:31:31',4,'S',NULL,'lucas Lucas Silva e Silva lu@cas.com.br 14997456672 99999999999'),
(4,NULL,'marcelo','$2y$10$CXhBDzuOYK1yq.jRpPxkoO.jfxVur..T3h.yhSULNsOmPC.QCHwCC','Marcelo','m@m.com.br','14997568775','22244455577',NULL,'2017-06-27 19:46:40',5,'S',NULL,'marcelo Marcelo m@m.com.br 14997568775 22244455577'),
(5,NULL,'visitante','$2y$10$PMbs40XwUrhDO8BFytKtxelS.Cp9A2RLD8mBNoAPUxjYCex4Q/VEe','Visitante','v@v.com.br',NULL,NULL,'2017-06-29 17:44:03','2017-07-11 02:32:43',6,'S',NULL,'visitante Visitante v@v.com.br   VISITANTE'),
(6,NULL,'teste','$2y$10$CXhBDzuOYK1yq.jRpPxkoO.jfxVur..T3h.yhSULNsOmPC.QCHwCC','Usuário Teste','teste@test.com.br',NULL,NULL,NULL,NULL,2,'S',NULL,'test Usuário Teste teste@test.com.br');

/* Procedure structure for procedure `atas_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `atas_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*
	FROM atas T1
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_altera`(
	vid INT(11) UNSIGNED,
        vnum INT(11),
        vdata DATE,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE atas
	SET
	num = vnum,
	data = vdata,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivos_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivos_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivos_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.num ata_descricao
	FROM ata_arquivos T1
        LEFT JOIN atas T2
               ON T1.ata_id = T2.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_altera`(
	vid INT(11) UNSIGNED,
        vata_id INT(11) UNSIGNED,
        vnome VARCHAR(60),
        vdataupload DATE,
        vuser_id INT(11) UNSIGNED,
        vempresa_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE ata_arquivos
	SET
	ata_id = vata_id,
	nome = vnome,
	dataupload = vdataupload,
	user_id = vuser_id,
	empresa_id = vempresa_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_insere`(
	vata_id INT(11) UNSIGNED,
        vnome VARCHAR(60),
        vdataupload DATE,
        vuser_id INT(11) UNSIGNED,
        vempresa_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO ata_arquivos
	(ata_id, nome, dataupload, user_id, empresa_id, created, modified)
	VALUES
	(vata_id, vnome, vdataupload, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_arquivo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_arquivo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_arquivo_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM ata_arquivos 
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_insere`(
	vnum INT(11),
        vdata DATE,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO atas
	(num, data, user_id, empresa_id, created, modified)
	VALUES
	(vnum, vdata, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ata_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `ata_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ata_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM atas 
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

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargos_seleciona`()
BEGIN
	SELECT T1.*
	FROM cargos T1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargo_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargo_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(45),
        vdescricao TEXT,
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE cargos
	SET
	nome = vnome,
	descricao = vdescricao,
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
	vnome VARCHAR(45),
        vdescricao TEXT,
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO cargos
	(nome, descricao, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `cargo_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `cargo_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT *
	FROM cargos 
	WHERE id = vid;
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
	vid INT(11) UNSIGNED,
        vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE departamentos
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

/* Procedure structure for procedure `departamento_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `departamento_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `departamento_insere`(
	vnome VARCHAR(80),
        vdescricao TEXT,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO departamentos
	(nome, descricao, empresa_id, user_id, created, modified)
	VALUES
	(vnome, vdescricao, vempresa_id, vuser_id, vcreated, vmodified);
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
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `empresa_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `empresa_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `empresa_altera`(
	vid INT(11),
        vnome VARCHAR(150),
        vcnpj VARCHAR(14),
        vtelefone VARCHAR(15),
        vendereco VARCHAR(150),
        vnumero VARCHAR(5),
        vcomplemento VARCHAR(50),
        vbairro VARCHAR(45),
        vcidade VARCHAR(45),
        vuf VARCHAR(2),
        vemail VARCHAR(150),
        vmatriz_id VARCHAR(5),
        vtipo INT(11),
        vsubdomain VARCHAR(15)
)
BEGIN
	UPDATE empresas
	SET
	nome = vnome,
	cnpj = vcnpj,
	telefone = vtelefone,
	endereco = vendereco,
	numero = vnumero,
	complemento = vcomplemento,
	bairro = vbairro,
	cidade = vcidade,
	uf = vuf,
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
	vnome VARCHAR(150),
        vcnpj VARCHAR(14),
        vtelefone VARCHAR(15),
        vendereco VARCHAR(150),
        vnumero VARCHAR(5),
        vcomplemento VARCHAR(50),
        vbairro VARCHAR(45),
        vcidade VARCHAR(45),
        vuf VARCHAR(2),
        vemail VARCHAR(150),
        vmatriz_id VARCHAR(5),
        vtipo INT(11),
        vsubdomain VARCHAR(15)
)
BEGIN
	INSERT INTO empresas
	(nome, cnpj, telefone, endereco, numero, complemento, bairro, cidade, uf, email, matriz_id, tipo, subdomain)
	VALUES
	(vnome, vcnpj, vtelefone, vendereco, vnumero, vcomplemento, vbairro, vcidade, vuf, vemail, vmatriz_id, vtipo, vsubdomain);
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
	SELECT *
	FROM enderecos
	WHERE cep = vcep;
END */$$
DELIMITER ;

/* Procedure structure for procedure `endereco_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `endereco_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_altera`(
	vid INT(11) UNSIGNED,
        vlogradouro VARCHAR(70),
        vnumero VARCHAR(10),
        vcomplemento VARCHAR(70),
        vbairro VARCHAR(45),
        vcep VARCHAR(10),
        vcidade VARCHAR(100),
        vestado_id INT(11) UNSIGNED,
        vmembro_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE enderecos
	SET
	logradouro = vlogradouro,
	numero = vnumero,
	complemento = vcomplemento,
	bairro = vbairro,
	cep = vcep,
	cidade = vcidade,
	estado_id = vestado_id,
	membro_id = vmembro_id,
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
	vlogradouro VARCHAR(70),
        vnumero VARCHAR(10),
        vcomplemento VARCHAR(70),
        vbairro VARCHAR(45),
        vcep VARCHAR(10),
        vcidade VARCHAR(100),
        vestado_id INT(11) UNSIGNED,
        vmembro_id INT(11) UNSIGNED,
        vuser_id INT(11),
        vempresa_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO enderecos
	(logradouro, numero, complemento, bairro, cep, cidade, estado_id, membro_id, user_id, empresa_id, created, modified)
	VALUES
	(vlogradouro, vnumero, vcomplemento, vbairro, vcep, vcidade, vestado_id, vmembro_id, vuser_id, vempresa_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `endereco_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `endereco_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `endereco_seleciona`(
	vid INT(11) UNSIGNED
)
BEGIN
	SELECT e.*,
	       m.enderecos_numero
	FROM enderecos e
	INNER JOIN membros m
		ON e.id = m.enderecos_id
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

/* Procedure structure for procedure `fornecedores_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedores_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedores_seleciona`(
	vempresa INT(11)
)
BEGIN
	SELECT T1.*, T2.sigla estado_descricao
	FROM fornecedores T1
        LEFT JOIN estados T2
               ON T1.estado_id = T2.id
        
        WHERE empresa_id = vempresa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedor_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedor_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedor_altera`(
	vid INT(10) UNSIGNED,
        vnome_fantasia VARCHAR(150),
        vrazao_social VARCHAR(150),
        vcnpj VARCHAR(15),
        vemail VARCHAR(100),
        vtelefone VARCHAR(11),
        vtelefone2 VARCHAR(11),
        vestado_id INT(10) UNSIGNED,
        vcidade VARCHAR(100),
        vlogradouro VARCHAR(150),
        vcomplemento VARCHAR(50),
        vcep VARCHAR(8),
        vempresa_id INT(10) UNSIGNED,
        vuser_id INT(10) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
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
	estado_id = vestado_id,
	cidade = vcidade,
	logradouro = vlogradouro,
	complemento = vcomplemento,
	cep = vcep,
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
	vnome_fantasia VARCHAR(150),
        vrazao_social VARCHAR(150),
        vcnpj VARCHAR(15),
        vemail VARCHAR(100),
        vtelefone VARCHAR(11),
        vtelefone2 VARCHAR(11),
        vestado_id INT(10) UNSIGNED,
        vcidade VARCHAR(100),
        vlogradouro VARCHAR(150),
        vcomplemento VARCHAR(50),
        vcep VARCHAR(8),
        vempresa_id INT(10) UNSIGNED,
        vuser_id INT(10) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	INSERT INTO fornecedores
	(nome_fantasia, razao_social, cnpj, email, telefone, telefone2, estado_id, cidade, logradouro, complemento, cep, empresa_id, user_id, created, modified)
	VALUES
	(vnome_fantasia, vrazao_social, vcnpj, vemail, vtelefone, vtelefone2, vestado_id, vcidade, vlogradouro, vcomplemento, vcep, vempresa_id, vuser_id, vcreated, vmodified);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `fornecedor_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `fornecedor_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `fornecedor_seleciona`(
	vid INT(10) UNSIGNED
)
BEGIN
	SELECT *
	FROM fornecedores 
	WHERE id = vid;
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
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE) 
		  AND T1.empresa_id = vempresa_id
		ORDER BY T1.nome;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND T1.empresa_id = vempresa_id
		  AND T1.ativo = 1
		ORDER BY T1.nome;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE MATCH(T1.membros_ft) AGAINST(CONCAT('\'', vpar, '*', '\'') IN BOOLEAN MODE)
		  AND T1.empresa_id = vempresa_id
		  AND T1.ativo <> 1
		ORDER BY T1.nome;
	END IF;
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
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE T1.empresa_id = vempresa
		ORDER BY T1.nome;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE T1.empresa_id = vempresa
		  AND T1.ativo = 1
		ORDER BY T1.nome;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		WHERE T1.empresa_id = vempresa
		  AND T1.ativo <> 1
		ORDER BY T1.nome;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_altera`(
	vid INT(11) UNSIGNED,
        vativo INT(11),
        vnome VARCHAR(100),
        vsexo CHAR(1),
        vdatanascimento DATE,
        vnaturalidade VARCHAR(100),
        vestado_id INT(11) UNSIGNED,
        vestadocivil INT(11),
        vlatitude VARCHAR(50),
        vlongitude VARCHAR(50),
        vrg VARCHAR(20),
        vcpf VARCHAR(20),
        vemail VARCHAR(150),
        vfone VARCHAR(20),
        vcel VARCHAR(20),
        vescolaridade_id INT(11) UNSIGNED,
        vprofissao_id INT(11) UNSIGNED,
        vempresa VARCHAR(150),
        vdatabatismo DATE,
        vigrejabatismo VARCHAR(30),
        vpastorbatismo VARCHAR(20),
        vultimaigreja VARCHAR(30),
        vdatamembro DATE,
        vigrejasanteriores TEXT,
        vcargo_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME,
        vtipo CHAR(1)
)
BEGIN
	UPDATE membros
	SET
	ativo = vativo,
	nome = vnome,
	sexo = vsexo,
	datanascimento = vdatanascimento,
	naturalidade = vnaturalidade,
	estado_id = vestado_id,
	estadocivil = vestadocivil,
	latitude = vlatitude,
	longitude = vlongitude,
	rg = vrg,
	cpf = vcpf,
	email = vemail,
	fone = vfone,
	cel = vcel,
	escolaridade_id = vescolaridade_id,
	profissao_id = vprofissao_id,
	empresa = vempresa,
	databatismo = vdatabatismo,
	igrejabatismo = vigrejabatismo,
	pastorbatismo = vpastorbatismo,
	ultimaigreja = vultimaigreja,
	datamembro = vdatamembro,
	igrejasanteriores = vigrejasanteriores,
	cargo_id = vcargo_id,
	empresa_id = vempresa_id,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified,
	tipo = vtipo
	WHERE id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `membro_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `membro_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_insere`(
	vativo INT(11),
        vnome VARCHAR(100),
        vsexo CHAR(1),
        vdatanascimento DATE,
        vnaturalidade VARCHAR(100),
        vestado_id INT(11) UNSIGNED,
        vestadocivil INT(11),
        vlatitude VARCHAR(50),
        vlongitude VARCHAR(50),
        vrg VARCHAR(20),
        vcpf VARCHAR(20),
        vemail VARCHAR(150),
        vfone VARCHAR(20),
        vcel VARCHAR(20),
        vescolaridade_id INT(11) UNSIGNED,
        vprofissao_id INT(11) UNSIGNED,
        vempresa VARCHAR(150),
        vdatabatismo DATE,
        vigrejabatismo VARCHAR(30),
        vpastorbatismo VARCHAR(20),
        vultimaigreja VARCHAR(30),
        vdatamembro DATE,
        vigrejasanteriores TEXT,
        vcargo_id INT(11) UNSIGNED,
        vempresa_id INT(11),
        vuser_id INT(11),
        vcreated DATETIME,
        vmodified DATETIME,
        vtipo CHAR(1)
)
BEGIN
	INSERT INTO membros
	(ativo, nome, sexo, datanascimento, naturalidade, estado_id, estadocivil, latitude, longitude, rg, cpf, email, fone, cel, escolaridade_id, profissao_id, empresa, databatismo, igrejabatismo, pastorbatismo, ultimaigreja, datamembro, igrejasanteriores, cargo_id, empresa_id, user_id, created, modified, tipo)
	VALUES
	(vativo, vnome, vsexo, vdatanascimento, vnaturalidade, vestado_id, vestadocivil, vlatitude, vlongitude, vrg, vcpf, vemail, vfone, vcel, vescolaridade_id, vprofissao_id, vempresa, vdatabatismo, vigrejabatismo, vpastorbatismo, vultimaigreja, vdatamembro, vigrejasanteriores, vcargo_id, vempresa_id, vuser_id, vcreated, vmodified, vtipo);
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
