ALTER TABLE `igreja`.`categorias_financeira`   
  ADD COLUMN `responsavel` CHAR(2) NULL   COMMENT 'PA - pastor, PR - presidente' AFTER `ativo`;
