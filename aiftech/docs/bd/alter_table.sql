ALTER TABLE `igreja`.`atas`   
  ADD COLUMN `finalizado` CHAR(1) DEFAULT 'N'  NULL AFTER `secretario`;
ALTER TABLE `igreja`.`parametros_sistema`   
  ADD COLUMN `id_presidentes_ata` VARCHAR(50) DEFAULT NULL  NULL AFTER `idade_quorum`
  ADD COLUMN `id_secretarios_ata` VARCHAR(50) DEFAULT NULL  NULL AFTER `id_presidente_ata`;