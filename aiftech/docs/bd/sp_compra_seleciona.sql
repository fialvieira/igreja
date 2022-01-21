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

/* Procedure structure for procedure `compra_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `compra_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `compra_seleciona`(
	vid INT(11) UNSIGNED,
	vempresa_id INT(11)
)
BEGIN
	SELECT C.*
				,S.nome solicitante_nome
				,A.nome autorizador_nome
				,CO.fornecedores_id fornecedor
	FROM compras C
  INNER JOIN membros S
    ON C.solicitante_id = S.id
   AND C.empresa_id = S.empresa_id
  LEFT JOIN membros A
    ON C.autorizador_id = A.id
   AND C.empresa_id = A.empresa_id
  LEFT JOIN compras_orcamentos CO
		ON C.id = CO.compras_id
	 AND C.empresa_id = CO.empresa_id
	WHERE C.id = vid
	  AND C.empresa_id = vempresa_id;	
	
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
