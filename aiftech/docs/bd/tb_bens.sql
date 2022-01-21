ALTER TABLE `igreja`.`bens`   
  DROP COLUMN `quantidade`, 
  DROP COLUMN `membro_id`, 
  ADD COLUMN `ativo` CHAR(1) NULL AFTER `tipo_bem_id`,
  CHANGE `nome` `nome` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `descricao` `descricao` VARCHAR(300) CHARSET utf8 COLLATE utf8_general_ci NULL,
  CHANGE `congregacao_id` `local_id` INT(11) UNSIGNED NULL,
  DROP INDEX `fk_bens_has_membros`,
  ADD  INDEX `fk_bens_has_locais` (`local_id`),
  DROP FOREIGN KEY `fk_bens_has_membros`,
  ADD CONSTRAINT `fk_bens_has_locais` FOREIGN KEY (`local_id`) REFERENCES `igreja`.`local`(`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;
