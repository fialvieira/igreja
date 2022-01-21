ALTER TABLE `igreja`.`compras_itens`  
  ADD CONSTRAINT `fk_compras_orcamentos` FOREIGN KEY (`compras_id`, `fornecedores_id`) REFERENCES `igreja`.`compras_orcamentos`(`fornecedores_id`, `compras_id`);
