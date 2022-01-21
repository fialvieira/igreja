DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_orcamentos_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_orcamentos_sel`(
			 vempresa_id	INT(11)
			,vcompra_id 	INT(11) UNSIGNED
			,vselecionado   CHAR(1)
			,vsituacao	CHAR(1)
    )
BEGIN
	
			SELECT DISTINCT 
						 CO.`compras_id` compras_id
						,F.`razao_social` fornecedor_nome
						,CO.`data_orcamento`
						,IFNULL(CI.`valor_unitario`, 0.00) valor_unitario
						,IFNULL(CI.`valor_total`, 0.00) valor
						,CASE IFNULL(CI.`fornecedores_id`, '')
							WHEN '' THEN 'N'
							ELSE 'S'
						 END aprovado
						,CO.`orcamento_path`
						,P.id produto_id
						,P.nome produto_nome
						,P.descricao produto_descricao
						,P.ativo produto_ativo
						,P.tipo
						,CASE
							WHEN P.tipo = 'P' THEN 'Produto'
							ELSE 'Serviço'
						 END tipo_descricao
						,P.unidade_medida
						,CI.quantidade
						,TP.nome tipo_produto_nome
						,TP.descricao tipo_produto_descricao
			FROM compras_orcamentos CO
			INNER JOIN compras CP
				ON CO.`compras_id` = CP.`id`
			       AND CO.`empresa_id` = CP.`empresa_id`
			       AND CP.`situacao` = IFNULL(vsituacao, CP.`situacao`) COLLATE utf8_unicode_ci
			INNER JOIN fornecedores F
				ON CO.`fornecedores_id` = F.`id`
			 AND CO.`empresa_id` = F.`empresa_id`
			LEFT JOIN compras_itens CI
				ON CO.`compras_id` = CI.`compras_id`
			 AND CO.`empresa_id` = CI.`empresa_id`
			 AND CO.`fornecedores_id` = CI.`fornecedores_id`
			LEFT JOIN produtos P
				ON CI.produtos_id = P.id
			 AND CI.empresa_id = P.empresa_id
			LEFT JOIN tipo_produtos TP
				ON P.tipo_produto_id = TP.id
			 AND P.empresa_id = TP.empresa_id
			WHERE CO.`empresa_id` = vempresa_id
				AND CO.`compras_id` = vcompra_id
				AND CASE 
							WHEN vselecionado = 'N' THEN CI.`fornecedores_id` IS NULL
							ELSE CI.`fornecedores_id` IS NOT NULL
						END;

    END$$

DELIMITER ;