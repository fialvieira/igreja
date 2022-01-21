ALTER TABLE `igreja`.`compras_orcamentos`   
  ADD COLUMN `nome_arquivo` VARCHAR(115) NOT NULL AFTER `orcamento_path`;