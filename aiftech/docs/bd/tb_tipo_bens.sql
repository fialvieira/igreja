ALTER TABLE `igreja`.`tipo_bens`   
  ADD COLUMN `ativo` CHAR(1) NULL AFTER `descricao`,
  CHANGE `modified` `modified` DATETIME NULL   COMMENT 'oculto';