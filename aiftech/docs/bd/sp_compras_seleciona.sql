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

/* Procedure structure for procedure `compras_seleciona` */

/*!50003 DROP PROCEDURE IF EXISTS  `compras_seleciona` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_seleciona`(
	vempresa INT(11),
	vsolicitante int(11) unsigned,
	vdata_ini datetime,
	vdata_fim DATEtime,
	vsituacao char(1)
)
BEGIN
	SELECT C.*
				,CASE
					WHEN C.situacao = 'S' THEN 'Solicitado'
					WHEN C.situacao = 'A' THEN 'Aprovado'
					WHEN C.situacao = 'R' THEN 'Recusado'
					WHEN C.situacao = 'P' THEN 'Pré-Aprovado'
					ELSE 'Executado'
				 END situacao_descricao
			,S.nome solicitante_nome
			,A.nome autorizador_nome
	FROM compras C
	INNER JOIN membros S
		ON C.solicitante_id = S.id
	 AND C.empresa_id = S.empresa_id
	LEFT JOIN membros A
		ON C.autorizador_id = A.id
	 AND C.empresa_id = A.empresa_id
	WHERE C.empresa_id = vempresa
		AND C.data_solicitacao BETWEEN vdata_ini AND vdata_fim
		AND C.situacao = IFNULL(vsituacao, C.situacao) COLLATE utf8_unicode_ci
		AND C.solicitante_id = IFNULL(vsolicitante, C.solicitante_id);		
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
