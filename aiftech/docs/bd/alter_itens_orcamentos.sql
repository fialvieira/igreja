ALTER TABLE `igreja`.`compras_itens`   
  ADD COLUMN `fornecedores_id` INT UNSIGNED NULL AFTER `modified`;
  
 ALTER TABLE `igreja`.`compras_orcamentos`   
  ADD COLUMN `aprovador_id` INT(11) NULL AFTER `aprovado`,
  ADD COLUMN `data_aprovacao` DATETIME NULL AFTER `aprovador_id`;