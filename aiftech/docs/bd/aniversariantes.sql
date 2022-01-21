SELECT  m.nome,
	m.datanascimento,
	CAST(CONCAT(CAST(YEAR(CURDATE()) AS CHAR), '-',  LPAD(CAST(MONTH(m.datanascimento) AS CHAR), 2, 0), '-', LPAD(CAST(DAY(m.datanascimento) AS CHAR), 2, 0)) AS DATE) aniversario,
	CASE DAYNAME(CAST(CONCAT(CAST(YEAR(CURDATE()) AS CHAR), '-',  LPAD(CAST(MONTH(m.datanascimento) AS CHAR), 2, 0), '-', LPAD(CAST(DAY(m.datanascimento) AS CHAR), 2, 0)) AS DATE))
		WHEN 'Monday' THEN 'Segunda-feira'
		WHEN 'Tuesday' THEN 'Terça-feira'
		WHEN 'Wednesday' THEN 'Quarta-feira'
		WHEN 'Thursday' THEN 'Quinta-feira'
		WHEN 'Friday' THEN 'Sexta-feira'
		WHEN 'Saturday' THEN 'Sábado'
		WHEN 'Sunday' THEN 'Domingo'
	END dia,
	TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) idade
FROM membros m
INNER JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
WHERE m.empresa_id = 1
  AND MONTH(m.datanascimento) = '01'
  AND m.`datanascimento` <> '2016-01-01'
  AND mf.status = 'A'
ORDER BY m.nome;