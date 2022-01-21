/*
SQLyog Ultimate v12.09 (64 bit)
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

/*Table structure for table `bodas` */

DROP TABLE IF EXISTS `bodas`;

CREATE TABLE `bodas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tempo` int(4) NOT NULL,
  `nome` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `bodas` */

insert  into `bodas`(`id`,`tempo`,`nome`) values (1,12,'Papel'),(2,24,'Algodão'),(3,36,'Trigo ou Couro'),(4,48,'Flores e Frutas ou Cera'),(5,60,'Madeira ou Ferro'),(6,72,'Perfume ou Açúcar'),(7,84,'Latão ou Lã'),(8,96,'Papoula ou Barro'),(9,108,'Cerâmica ou Vime'),(10,120,'Estanho ou Zinco'),(11,132,'Aço'),(12,144,'Seda ou Ônix'),(13,156,'Linho ou Renda'),(14,168,'Marfim'),(15,180,'Cristal'),(16,192,'Turmalina'),(17,204,'Rosa'),(18,216,'Turquesa'),(19,228,'Cretone ou Água-marinha'),(20,240,'Porcelana'),(21,252,'Zircão'),(22,264,'Louça'),(23,276,'Palha'),(24,288,'Opala'),(25,300,'Prata'),(26,312,'Alexandrita'),(27,324,'Crisopázio'),(28,336,'Hematita'),(29,348,'Erva'),(30,360,'Pérola'),(31,372,'Nácar'),(32,384,'Pinho'),(33,396,'Crizo'),(34,408,'Oliveira'),(35,420,'Coral'),(36,432,'Cedro'),(37,444,'Aventurina'),(38,456,'Carvalho'),(39,468,'Mármore'),(40,480,'Rubi ou Esmeralda'),(41,492,'Seda'),(42,504,'Prata Dourada'),(43,516,'Azeviche'),(44,528,'Carbonato'),(45,540,'Platina ou Safira'),(46,552,'Alabastro'),(47,564,'Jaspe'),(48,576,'Granito'),(49,588,'Heliotrópio'),(50,600,'Ouro'),(51,612,'Bronze'),(52,624,'Argila'),(53,636,'Antimônio'),(54,648,'Níquel'),(55,660,'Ametista'),(56,672,'Malaquita'),(57,684,'Lápis Lazuli'),(58,696,'Vidro'),(59,708,'Cereja'),(60,720,'Diamante ou Jade'),(61,732,'Cobre'),(62,744,'Telurita'),(63,756,'Sândalo ou Lilás'),(64,768,'Fabulita'),(65,780,'Ferro'),(66,792,'Ébanos'),(67,804,'Neve'),(68,816,'Chumbo'),(69,828,'Mercúrio'),(70,840,'Vinho'),(71,1,'Beijinhos'),(72,2,'Sorvete'),(73,3,'Algodão Doce'),(74,4,'Pipoca'),(75,5,'Chocolate'),(76,6,'Plumas'),(77,7,'Purpurina'),(78,8,'Pom Pom'),(79,9,'Maternidade'),(80,10,'Pintinho'),(81,11,'Chicletes');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
