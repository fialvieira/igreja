SELECT m.`id` membro_id
			,m.`nome` membro
			,c.`id` cargo_id
			,c.`nome` cargo
			,d.`id` departamento_id
			,d.`nome` departamento
FROM assoc_membros_cargos_departamentos mcd
INNER JOIN membros m
	ON mcd.`membro_id` = m.`id`
 AND mcd.`empresa_id` = m.`empresa_id`
INNER JOIN cargos c
	ON mcd.`cargo_id` = c.`id`
 AND mcd.`empresa_id` = c.`empresa_id`
INNER JOIN departamentos d
	ON mcd.`departamento_id` = d.`id`
 AND mcd.`empresa_id` = d.`empresa_id`
WHERE mcd.`empresa_id` = 1
	AND mcd.`ativo` = 'S'
	AND c.`id` IN (3, 4)