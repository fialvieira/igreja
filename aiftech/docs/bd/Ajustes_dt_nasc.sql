SELECT *
FROM membros
WHERE datanascimento IS NULL;


SELECT ms.`datanascimento`,
	m.`MEM_DT_NASC`
FROM membros ms
INNER JOIN membro m
	ON ms.nome = m.MEM_NOM
WHERE ms.`datanascimento` IS NULL;


START TRANSACTION;
UPDATE membros AS ms
INNER JOIN membro AS m
	ON ms.nome = m.MEM_NOM
SET ms.datanascimento = m.`MEM_DT_NASC`
WHERE ms.`datanascimento` IS NULL;

COMMIT;