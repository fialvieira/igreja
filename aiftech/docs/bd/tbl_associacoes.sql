CREATE TABLE `igreja`.`associacoes`(  
  `id` INT NOT NULL AUTO_INCREMENT,
  `sigla` VARCHAR(10) NOT NULL,
  `descricao` VARCHAR(250) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `user_id` INT(11) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;
