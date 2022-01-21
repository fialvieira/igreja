SELECT  mf.frequencia,
	COUNT(*) TOTAL
FROM membros m
INNER JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
       AND m.empresa_id = mf.empresa_id
INNER JOIN LOCAL l
	ON m.local_id = l.id
       AND m.empresa_id = l.empresa_id
WHERE mf.status = 'A'
  AND mf.quorum = 'S'
  AND l.e_sede = 'S'
  AND l.ativo = 'S'
  AND m.empresa_id = 1
GROUP BY mf.frequencia;