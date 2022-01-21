ALTER TABLE `igreja`.`produtos`   
  ADD COLUMN `tipo` CHAR(1) DEFAULT 'P'  NOT NULL AFTER `ativo`;