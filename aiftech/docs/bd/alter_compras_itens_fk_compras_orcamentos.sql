ALTER TABLE `igreja`.`compras_itens` DROP FOREIGN KEY `fk_compras_orcamentos`;

ALTER TABLE `igreja`.`compras_itens` ADD CONSTRAINT `fk_compras_orcamentos` FOREIGN KEY (`compras_id`, `fornecedores_id`) REFERENCES `igreja`.`compras_orcamentos`(`compras_id`, `fornecedores_id`) ON UPDATE NO ACTION ON DELETE NO ACTION;
