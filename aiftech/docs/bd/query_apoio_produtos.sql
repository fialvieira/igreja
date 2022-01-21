/*Seleciona produtos*/
SELECT p.*
			,tp.`nome` tipo_produto
FROM produtos p
LEFT JOIN tipo_produtos tp
  ON p.`tipo_produto_id` = tp.`id`
 AND p.`empresa_id` = tp.`empresa_id`
WHERE p.`empresa_id` = 1;

/*Seleciona fornecedores por produto*/
SELECT f.*
FROM fornecedores f
INNER JOIN assoc_fornecedores_produtos afp
	ON f.`id` = afp.`fornecedores_id`
 AND f.`empresa_id` = afp.`empresa_id`
WHERE 1 = 1
	AND afp.`produtos_id` = 1
	AND f.`empresa_id` = 1
	AND f.`ativo` = 'S';