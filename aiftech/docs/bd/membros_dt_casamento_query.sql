SELECT CASE
					WHEN m1.sexo = 'F' THEN SUBSTRING(m1.`nome`, 1, LOCATE(' ', m1.`nome`))
					ELSE SUBSTRING(m2.`nome`, 1, LOCATE(' ', m2.`nome`))
			 END nome1
			,CASE
					WHEN m2.sexo = 'M' THEN m2.`nome`
					ELSE m1.`nome`
			 END nome2
			,CONCAT(LPAD(DAY(m1.`data_casamento`), 2, '0'), '/', LPAD(MONTH(m1.`data_casamento`), 2, '0')) data_casamento
			,CASE
				WHEN TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()) < 1 THEN CONCAT(TIMESTAMPDIFF(MONTH, m1.`data_casamento`, CURDATE()), ' meses')
				ELSE CONCAT(TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()), CASE
																																					WHEN TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()) = 1 THEN ' ano'
																																					WHEN TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()) > 1 THEN ' anos'
																																				 END)
			 END tempo
			,b.`nome` bodas
FROM relacionamentos r
LEFT JOIN membros m1
	ON r.`membro_id` = m1.`id`
INNER JOIN membros_frequencia mf1
	ON m1.`frequencia_id` = mf1.`id`
LEFT JOIN membros m2
	ON r.`membro2_id` = m2.`id`
INNER JOIN membros_frequencia mf2
	ON m2.`frequencia_id` = mf2.`id`
LEFT JOIN bodas b
	ON CASE
			WHEN TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()) < 1 THEN TIMESTAMPDIFF(MONTH, m1.`data_casamento`, CURDATE())
			ELSE TIMESTAMPDIFF(YEAR, m1.`data_casamento`, CURDATE()) * 12
		 END = b.`tempo`
WHERE r.`empresa_id` = 1
	AND MONTH(m1.`data_casamento`) = 3
	AND (mf1.`status` = 'A' AND mf2.`status` = 'A')
ORDER BY DAY(m1.`data_casamento`)