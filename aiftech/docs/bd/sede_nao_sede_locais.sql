SELECT	l.nome,
	mf.frequencia,
	COUNT(mf.frequencia) TOTAL
FROM membros m
INNER JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
       AND m.empresa_id = mf.empresa_id
INNER JOIN LOCAL l
	ON m.local_id = l.id
       AND m.empresa_id = l.empresa_id
WHERE l.e_sede <> 'S'
  AND l.sede = 'N'
  AND mf.quorum = 'N'
  AND mf.status <> 'I'
  AND m.empresa_id = 1
GROUP BY l.nome,
	 mf.frequencia
