ALTER TABLE `igreja_hom`.`mov_fin_arquivos`  
  ADD CONSTRAINT `fk_mov_finac_id_mov_financ_arq` FOREIGN KEY (`movimentacao_financeira_id`) REFERENCES `igreja_hom`.`movimentacao_financeira`(`id`);
