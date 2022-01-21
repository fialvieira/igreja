ALTER TABLE `igreja`.`compras`   
  ADD COLUMN `data` DATE NULL AFTER `membro_id`,
  CHANGE `justificativa` `justificativa` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL  AFTER `data`,
  CHANGE `autorizador_id` `autorizador_id` INT(11) UNSIGNED NULL  AFTER `justificativa`,
  CHANGE `data_autorizacao` `data_autorizacao` DATE NULL  AFTER `autorizador_id`,
  CHANGE `tesoureiro_id` `tesoureiro_id` INT(11) UNSIGNED NULL  AFTER `data_autorizacao`,
  CHANGE `data_tesouraria` `data_tesouraria` DATE NULL  AFTER `tesoureiro_id`,
  CHANGE `valor_tesouraria` `valor_tesouraria` DECIMAL(10,2) NULL  AFTER `data_tesouraria`,
  CHANGE `data_nota` `data_nota` DATE NULL  AFTER `valor_tesouraria`,
  CHANGE `valor_nota` `valor_nota` DECIMAL(10,2) NULL  AFTER `data_nota`,
  CHANGE `numero_nota` `numero_nota` VARCHAR(20) CHARSET utf8 COLLATE utf8_unicode_ci NULL  AFTER `valor_nota`,
  CHANGE `observacao` `observacao` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL  AFTER `numero_nota`,
  ADD COLUMN `path_nota` VARCHAR(250) NULL AFTER `modified`;