SELECT m.`nome`
		  ,tr.`descricao`
		  ,(SELECT nome
				FROM membros mem
				LEFT JOIN relacionamentos rel
					ON mem.id = rel.membro2_id
				 AND mem.empresa_id = rel.empresa_id
				 WHERE rel.membro_id = m.`id`) nome1
			,CASE
						WHEN UPPER(SUBSTRING(e.`logradouro`, 1, 3)) = 'RUA' THEN
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 5, 1)))
						ELSE
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 1, 1)))
			 END letra
			,e.`logradouro`
			,m.`enderecos_numero`
			,m.`enderecos_complemento`
FROM membros m
LEFT JOIN membros_frequencia mf
	 ON m.frequencia_id = mf.id
	AND m.empresa_id = mf.`empresa_id`
LEFT JOIN relacionamentos r
	ON M.`id` = r.`membro_id`
 AND m.`empresa_id` = r.`empresa_id`
LEFT JOIN tipo_relacionamentos tr
	ON r.`tiporelacionamento_id` = tr.`id`
LEFT JOIN enderecos e
			 ON m.enderecos_id = e.`id`
LEFT JOIN estados T2
			 ON e.estado_id = T2.id
WHERE m.`empresa_id` = 1
  AND mf.status = IFNULL('A', mf.`status`)
  AND mf.quorum = IFNULL(NULL, mf.`quorum`)
ORDER BY e.`logradouro`, m.`enderecos_numero`, m.`nome`