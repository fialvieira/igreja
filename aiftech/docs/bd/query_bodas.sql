SELECT tbl.nome1
			 ,tbl.nome2
			 ,tbl.data_casamento
			 ,tbl.tempo
			 ,tbl.bodas
FROM
(SELECT CASE
					WHEN m1.sexo = 'F' THEN SUBSTRING(m1.`nome`, 1, LOCATE(' ', m1.`nome`))
					WHEN m2.sexo = 'F' THEN SUBSTRING(m2.`nome`, 1, LOCATE(' ', m2.`nome`))
				END nome1
				,CASE
					 WHEN m2.sexo = 'M' THEN m2.`nome`
					 WHEN m1.sexo = 'M' THEN m1.`nome`
				 END nome2
				,CONCAT(LPAD(DAY(m1.`data_casamento`), 2, '0'), '/', LPAD(MONTH(m1.`data_casamento`), 2, '0')) data_casamento
				,CASE
						 WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'M'), ' meses')
						 WHEN fn_diff_date(m1.`data_casamento`, 'M') = 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'M'), ' ano')
						 ELSE CONCAT(fn_diff_date(m1.`data_casamento`, 'A'), ' anos')
				 END tempo
				,(SELECT nome
					FROM bodas
					WHERE tempo = CASE
													WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN fn_diff_date(m1.`data_casamento`, 'M')
													ELSE (fn_diff_date(m1.`data_casamento`, 'A') * 12)
												END) bodas
FROM relacionamentos r
LEFT JOIN membros m1
								ON r.`membro_id` = m1.`id`
INNER JOIN membros_frequencia mf1
								ON m1.`frequencia_id` = mf1.`id`
LEFT JOIN membros m2
								ON r.`membro2_id` = m2.`id`
INNER JOIN membros_frequencia mf2
								ON m2.`frequencia_id` = mf2.`id`
WHERE r.`empresa_id` = ?
								AND MONTH(m1.`data_casamento`) = ?
								AND r.tiporelacionamento_id = 3
								AND (mf1.`status` = 'A' AND mf2.`status` = 'A')
								AND m2.id IS NOT NULL
ORDER BY DAY(m1.`data_casamento`)) tbl
GROUP BY tbl.data_casamento, tbl.tempo, tbl.nome1, tbl.nome2, tbl.bodas
ORDER BY MAX(tbl.data_casamento)