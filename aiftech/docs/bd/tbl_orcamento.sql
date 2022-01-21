CREATE TABLE `igreja`.`orcamento`(  
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ano` CHAR(4) NOT NULL,
  `mes` CHAR(2) NOT NULL,
  `categoria_id` INT(10) UNSIGNED NOT NULL,
  `valor_previsto` DECIMAL(10,2) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unq_ix_emp_ano_mes_cat` (`empresa_id`, `ano`, `mes`, `categoria_id`),
  CONSTRAINT `fk_orcamento_has_categoria_financeira` FOREIGN KEY (`categoria_id`) REFERENCES `igreja`.`categorias_financeira`(`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;