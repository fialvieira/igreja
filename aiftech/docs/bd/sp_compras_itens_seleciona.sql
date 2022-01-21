DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compras_itens_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compras_itens_seleciona`(
	vempresa 		INT(11),
	vcompras_id INT(11) UNSIGNED
)
BEGIN
	SELECT CI.compras_id
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
				,CI.valor_unitario
				,CI.valor_total
				,CI.fornecedores_id
				,TP.nome tipo_produto_nome
				,TP.descricao tipo_produto_descricao
	FROM compras_itens CI
	LEFT JOIN produtos P
		ON CI.produtos_id = P.id
	 AND CI.empresa_id = P.empresa_id
	LEFT JOIN tipo_produtos TP
		ON P.tipo_produto_id = TP.id
	 AND P.empresa_id = TP.empresa_id
	WHERE CI.empresa_id = vempresa
		AND CI.compras_id = vcompras_id;		
END$$

DELIMITER ;