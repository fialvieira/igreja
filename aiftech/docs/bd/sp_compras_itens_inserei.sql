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

/* Procedure structure for procedure `compras_itens_insere` */

/*!50003 DROP PROCEDURE IF EXISTS  `compras_itens_insere` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_itens_insere`(
	vcompras_id int(10) unsigned,
	vprodutos_id INT(10) UNSIGNED,
	vquantidade decimal(10,2),
	vvalor_unitario DECIMAL(10,2),
	vvalor_total DECIMAL(10,2),
	vfornecedores_id INT(10) UNSIGNED,
	vuser_id INT(11),
	vempresa_id INT(11),
	vcreated DATETIME
)
BEGIN
	INSERT INTO compras_itens
	(compras_id, produtos_id, quantidade, valor_unitario, valor_total, fornecedores_id, user_id, empresa_id, created)
	VALUES
	(vcompras_id, vprodutos_id, vquantidade, vvalor_unitario, vvalor_total, vfornecedores_id, vuser_id, vempresa_id, vcreated);
	
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
