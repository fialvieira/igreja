ALTER TABLE `igreja`.`compras`   
  ADD COLUMN `qtd_parcelas` INT(5) NULL AFTER `observacao`,
  ADD COLUMN `meio_pagamento_id` INT(11) UNSIGNED NULL AFTER `qtd_parcelas`;
