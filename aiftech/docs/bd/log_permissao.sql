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
USE `igreja`;

/*Table structure for table `log_permissao` */

DROP TABLE IF EXISTS `log_permissao`;

CREATE TABLE `log_permissao` (
  `usuario` int(11) DEFAULT NULL COMMENT 'usuário que recebeu permissão',
  `modulo` int(11) DEFAULT NULL COMMENT 'módulo da permissão',
  `permissao_old` int(11) DEFAULT NULL COMMENT 'nível da permissão',
  `permissao_new` int(11) DEFAULT NULL,
  `acao` char(1) DEFAULT NULL COMMENT '(I)nsert; (U)pdate; (D)elete',
  `user_id` int(11) DEFAULT NULL COMMENT 'quem fez a ação',
  `created` datetime DEFAULT NULL COMMENT 'data da ação'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Trigger structure for table `permissoes` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `permissao_after_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `permissao_after_insert` AFTER INSERT ON `permissoes` FOR EACH ROW BEGIN
	-- Insert record into log table
	   INSERT INTO log_permissao
	   ( usuario,
		 modulo,
		 permissao_old,
		 permissao_new,
		 acao,
		 user_id,
		 created)
	   VALUES
	   ( NEW.usuario_id,
		 NEW.modulo_id,
		 NULL,
		 NEW.permissao,
		 'I',
		 NEW.user_id,
		 SYSDATE());
    END */$$


DELIMITER ;

/* Trigger structure for table `permissoes` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `permissao_after_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `permissao_after_update` AFTER UPDATE ON `permissoes` FOR EACH ROW BEGIN
		if OLD.permissao <> NEW.permissao then
	-- Insert record into log table
		   INSERT INTO log_permissao
		   ( usuario,
			 modulo,
			 permissao_old,
			 permissao_new,
			 acao,
			 user_id,
			 created)
		   VALUES
		   ( OLD.usuario_id,
			 OLD.modulo_id,
			 OLD.permissao,
			 NEW.permissao,
			 'U',
			 NEW.user_id,
			 SYSDATE());
		end if;	 
    END */$$


DELIMITER ;

/* Trigger structure for table `permissoes` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `permissao_before_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `permissao_before_delete` BEFORE DELETE ON `permissoes` FOR EACH ROW BEGIN
-- Insert record into log table
	   INSERT INTO log_permissao
	   ( usuario,
		 modulo,
		 permissao_old,
		 permissao_new,
		 acao,
		 user_id,
		 created)
	   VALUES
	   ( OLD.usuario_id,
		 OLD.modulo_id,
		 OLD.permissao,
		 NULL,
		 'D',
		 OLD.user_id,
		 SYSDATE());
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
