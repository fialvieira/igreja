ALTER TABLE `igreja`.`membros_frequencia`   
  ADD COLUMN `ativo` CHAR(1) CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '(S)im ou (N)ão' AFTER `status`;