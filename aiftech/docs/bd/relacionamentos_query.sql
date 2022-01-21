SELECT r.id
			,tr.`descricao`
			,r.`membro_id`
			,m.`nome` nome_um
			,r.`membro2_id`
			,m2.`nome` nome_dois
FROM relacionamentos r
INNER JOIN tipo_relacionamentos tr
	ON r.`tiporelacionamento_id` = tr.`id`
LEFT JOIN membros m
	ON r.`membro_id` = m.`id`
LEFT JOIN membros m2
	ON r.`membro2_id` = m2.`id`
WHERE r.`empresa_id` = 1
	AND (CASE
				WHEN r.`tiporelacionamento_id` = 3 THEN (membro_id = '3995' OR membro2_id = '3995')
				ELSE membro_id = '3995'
			END);