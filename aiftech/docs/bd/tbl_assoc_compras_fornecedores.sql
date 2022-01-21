CREATE TABLE `igreja`.`assoc_compras_fornecedores`(  
  `fornecedores_id` INT(11) UNSIGNED NOT NULL,
  `compras_id` INT(11) UNSIGNED NOT NULL,
  `orcamento_path` VARCHAR(800) NOT NULL,
  `data_orcamento` DATE,
  `aprovado` CHAR(1) COMMENT '(S)im ou (N)ão',
  `user_id` INT(11) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME,
  PRIMARY KEY (`fornecedores_id`, `compras_id`),
  CONSTRAINT `fk_assoc_compras_fornecedores_has_fornecedores` FOREIGN KEY (`fornecedores_id`) REFERENCES `igreja`.`fornecedores`(`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT `fk_assoc_compras_fornecedores_has_compras` FOREIGN KEY (`compras_id`) REFERENCES `igreja`.`compras`(`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;
