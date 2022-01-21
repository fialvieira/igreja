ALTER TABLE `igreja`.`centro_custo`   
  ADD COLUMN `principal` CHAR(1) NULL   COMMENT '(S)im para centro de custo principal' AFTER `descricao`;