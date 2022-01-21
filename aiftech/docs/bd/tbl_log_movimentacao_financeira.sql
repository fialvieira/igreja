CREATE TABLE `igreja`.`log_movimentacao_financeira`(  
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `movimentacao_financeira_id` INT(11) UNSIGNED,
  `valor_new` TEXT,
  `valor_old` TEXT,
  `cancelado` CHAR(1),
  `user_id_cancela` INT(11),
  `justifica_cancela` TEXT,
  `mov_empresa_id` INT(11),
  `mov_user_id` INT(11),
  `mov_created` DATETIME,
  `mov_modified` DATETIME,
  `acao` CHAR(1),
  `empresa_id` INT(11),
  `user_id` INT(11),
  `created` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;