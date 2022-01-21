DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_orcamentos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_orcamentos_seleciona`(
			 vempresa_id	INT(11)
			,vcompra_id 	INT(11) UNSIGNED
    )
BEGIN
    
    SELECT DISTINCT 
           CO.`compras_id` compras_id
					,F.`razao_social` fornecedor_nome
					,CO.`data_orcamento`
					,CO.fornecedores_id 
					,CO.nome_arquivo
					,IFNULL(CI.`valor_unitario`, 0.00) valor_unitario
					,IFNULL(CI.`valor_total`, 0.00) valor
					,CASE IFNULL(CI.`fornecedores_id`, '')
						WHEN '' THEN 'N'
						ELSE 'S'
					 END aprovado
					,CO.`orcamento_path`
		FROM compras_orcamentos CO
		INNER JOIN fornecedores F
			ON CO.`fornecedores_id` = F.`id`
		 AND CO.`empresa_id` = F.`empresa_id`
		LEFT JOIN compras_itens CI
			ON CO.`compras_id` = CI.`compras_id`
		 AND CO.`empresa_id` = CI.`empresa_id`
		 AND CO.`fornecedores_id` = CI.`fornecedores_id`
		WHERE CO.`empresa_id` = vempresa_id
			AND CO.`compras_id` = vcompra_id;

    END$$

DELIMITER ;