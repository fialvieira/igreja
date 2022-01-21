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

/*Table structure for table `menu_modulos` */

DROP TABLE IF EXISTS `menu_modulos`;

CREATE TABLE `menu_modulos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `menu_id` INT(11) NOT NULL,
  `descricao` VARCHAR(256) NOT NULL,
  `path` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `menu_modulos` */

INSERT  INTO `menu_modulos`(`id`,`menu_id`,`descricao`,`path`) VALUES 
(1,1,'Membros','app/cadastros/membros/index.php'),
(2,1,'Atas','app/cadastros/atas/index.php'),
(3,1,'Dons','app/cadastros/dons/index.php'),
(4,1,'Cargos','app/cadastros/cargos/index.php'),
(5,1,'Departamentos','app/cadastros/departamentos/index.php'),
(6,1,'Locais','app/cadastros/local/index.php'),
(7,1,'Profissões','app/cadastros/profissoes/index.php'),
(8,1,'Fornecedores','app/cadastros/fornecedores/index.php'),
(9,1,'Tipo Fornecedores','app/cadastros/tipo_fornecedores/index.php'),
(10,1,'Pastores','app/cadastros/pastores/index.php'),
(11,1,'Usuários','app/cadastros/usuarios/index.php'),
(12,2,'Membros Quórum','app/relatorios/membros_quorum/index.php'),
(13,2,'Membros Menores de 18 Anos','app/relatorios/membros_menores/index.php'),
(14,2,'Membros Aniversário de Casamento','app/relatorios/membros_matrimonios/index.php'),
(15,2,'Membros Aniversariantes','app/relatorios/membros_aniversariantes/index.php'),
(16,2,'Membros Inconsistências','app/relatorios/membros_inconsistencias/index.php');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

INSERT  INTO `menus`(`id`,`descricao`) VALUES 
(1,'Cadastros'),
(2,'Relatórios');

/*Table structure for table `permissoes` */

DROP TABLE IF EXISTS `permissoes`;

CREATE TABLE `permissoes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `modulo_id` INT(11) NOT NULL,
  `permissao` TINYINT(4) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL COMMENT 'oculto',
  `created` DATETIME DEFAULT NULL COMMENT 'oculto',
  `modified` DATETIME DEFAULT NULL COMMENT 'oculto',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `permissoes` */

INSERT  INTO `permissoes`(`id`,`usuario_id`,`modulo_id`,`permissao`,`empresa_id`,`user_id`,`created`,`modified`) VALUES 
(1,1,1,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(2,1,2,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(3,1,3,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(4,1,4,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(5,1,5,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(6,1,6,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(8,1,8,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(9,1,9,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(10,1,10,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(11,1,11,4,1,4,'2018-01-31 14:05:21','2018-02-01 11:05:46'),
(13,1,7,4,1,4,'2018-02-01 11:05:46',NULL),
(14,1,12,4,1,4,'2018-02-01 11:05:46',NULL),
(15,4,1,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(16,4,2,4,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(17,4,3,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(18,4,4,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(19,4,5,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(20,4,6,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(21,4,7,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(22,4,8,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(23,4,9,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(24,4,10,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(25,4,11,1,1,4,'2018-02-01 11:06:32','2018-02-01 11:08:18'),
(27,4,12,1,1,4,'2018-02-01 11:08:18',NULL),
(28,7,1,1,1,1,'2018-02-01 11:11:36','2018-02-17 02:32:42'),
(29,7,2,3,1,1,'2018-02-01 11:11:36','2018-02-17 02:32:42'),
(30,7,12,1,1,1,'2018-02-01 11:11:36','2018-02-17 02:32:42'),
(31,7,6,3,1,1,'2018-02-02 14:46:50','2018-02-17 02:32:42'),
(32,7,16,1,1,1,'2018-02-17 02:32:42',NULL);

/* Procedure structure for procedure `permissao_altera` */

/*!50003 DROP PROCEDURE IF EXISTS  `permissao_altera` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `permissao_altera`(
	vid int,
	vpermissao int,
	vuser_id 	 INT,
	vmodified  DATETIME
)
BEGIN
	update permissoes
	set permissao = vpermissao
	   ,user_id = vuser_id
	   ,modified = vmodified
	where id = vid;
END */$$
DELIMITER ;

/* Procedure structure for procedure `permissao_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `permissao_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `permissao_insere`(
	vusuario_id int,
	vmodulo_id int,
	vpermissao int,
	vempresa_id	INT,
	vuser_id 	INT,
	vcreated 	DATETIME
)
BEGIN
	INSERT INTO permissoes
	(usuario_id, modulo_id, permissao, empresa_id, user_id, created)
	VALUES
	(vusuario_id, vmodulo_id, vpermissao, vempresa_id, vuser_id, vcreated);
	SELECT LAST_INSERT_ID() id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `permissao_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `permissao_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `permissao_seleciona`(
	vid INT(11)
)
BEGIN
	SELECT p.*, u.nome usuario, m.descricao menu, mm.descricao modulo
	FROM permissoes p
	left join users u
		on p.usuario_id = u.id
	left join menu_modulos mm
		on p.modulo_id = mm.id
	left join menus m
		on mm.menu_id = m.id
	WHERE p.id = vid;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
