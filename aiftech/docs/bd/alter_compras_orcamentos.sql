ALTER TABLE `igreja`.`compras_orcamentos`   
  ADD COLUMN `aprovador_id` INT(11) NULL AFTER `aprovado`,
  ADD COLUMN `data_aprovacao` DATETIME NULL AFTER `aprovador_id`,
  ADD CONSTRAINT `fk_compras` FOREIGN KEY (`compras_id`) REFERENCES `igreja`.`compras`(`id`),
  ADD CONSTRAINT `fk_fornecedores` FOREIGN KEY (`fornecedores_id`) REFERENCES `igreja`.`fornecedores`(`id`);
