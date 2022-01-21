SELECT	COUNT(*) TOTAL_GERAL
FROM membros m
INNER JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
	AND m.empresa_id = mf.empresa_id
WHERE m.empresa_id = 1
  AND mf.status = IFNULL('A', mf.status);

SELECT 	COUNT(*) TOTAL_MENORES
FROM membros m
INNER JOIN parametros_sistema ps
	ON m.empresa_id = ps.empresa_id
INNER JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
	AND m.empresa_id = mf.empresa_id
WHERE m.empresa_id = 1
  AND mf.status = IFNULL('A', mf.status)
  AND mf.quorum = IFNULL('S', mf.quorum)
  AND TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) < ps.idade_quorum;
  