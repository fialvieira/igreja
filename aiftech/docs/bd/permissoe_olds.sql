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

/*Table structure for table `membros_frequencia` */

DROP TABLE IF EXISTS `membros_frequencia`;

CREATE TABLE `membros_frequencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequencia` varchar(255) NOT NULL,
  `status` char(1) NOT NULL,
  `quorum` char(1) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `membros_frequencia` */

insert  into `membros_frequencia`(`id`,`frequencia`,`status`,`quorum`,`empresa_id`,`user_id`,`created`,`modified`) values (1,'Assíduo(a)','A','S',1,NULL,NULL,NULL),(2,'Ausente','A','S',1,NULL,NULL,NULL),(3,'Ausente por doença','A','N',1,NULL,NULL,NULL),(4,'Desligado(a)','I','N',1,NULL,NULL,NULL),(5,'Desligado(a) por ausência','I','N',1,NULL,NULL,NULL),(6,'Em disciplina','A','S',1,NULL,NULL,NULL),(7,'Excluído(a)','I','N',1,NULL,NULL,NULL),(8,'Falecido(a)','I','N',1,NULL,NULL,NULL),(9,'Frequência Desconhecida','A','S',1,NULL,NULL,NULL),(10,'Frequência irregular','A','S',1,NULL,NULL,NULL),(11,'Frequenta outra Igreja','A','S',1,NULL,NULL,NULL),(12,'Idoso(a) com dificuldade de locomoção','A','N',1,NULL,NULL,NULL),(13,'Participa na Congregação','A','N',1,NULL,NULL,NULL),(14,'Reside em outra cidade','A','N',1,NULL,NULL,NULL),(15,'Transferido(a)','I','N',1,NULL,NULL,NULL),(16,'Assiste','A','N',1,NULL,NULL,NULL),(19,'Aguarda Carta','A','N',1,NULL,NULL,NULL),(20,'Outros Projetos','A','N',1,NULL,NULL,NULL),(21,'Pediu Carta e desistiu','I','N',1,NULL,NULL,NULL);

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
