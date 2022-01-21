SELECT *
FROM relacionamentos
WHERE empresa_id = 1
	AND (CASE
				WHEN tiporelacionamento_id = 3 THEN (membro_id = '3994' OR membro2_id = '3994')
				ELSE membro_id = '3994'
			END);