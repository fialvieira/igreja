ALTER TABLE `igreja`.`compras`   
  DROP COLUMN `tesoureiro_id`, 
  DROP COLUMN `data_tesouraria`, 
  DROP COLUMN `valor_tesouraria`, 
  CHANGE `data` `data_solicitacao` DATETIME NOT NULL;