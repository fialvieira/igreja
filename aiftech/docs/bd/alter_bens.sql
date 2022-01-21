ALTER TABLE `igreja`.`bens`   
  CHANGE `nome` `nome` VARCHAR(200) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  ADD COLUMN `marca` VARCHAR(200) NULL AFTER `num_ativo`,
  ADD COLUMN `modelo` VARCHAR(200) NULL AFTER `marca`,
  CHANGE `descricao` `descricao` VARCHAR(500) CHARSET utf8 COLLATE utf8_general_ci NULL,
  CHANGE `garantia` `garantia` DATE NULL  AFTER `data_compra`, 
  CHANGE `identificacao` `identificacao` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `num_ativo` `num_ativo` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  ADD  UNIQUE INDEX `unq_identificacao` (`identificacao`),
  ADD  UNIQUE INDEX `unq_num_ativo` (`num_ativo`);
