SELECT m.`nome`
			,m.`datanascimento`
			,TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) idade
FROM membros m
WHERE TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) < 18
	AND m.`datanascimento` <> '2016-01-01'
ORDER BY nome