SELECT m.`nome`
			,c.`nome` cargo
			,d.`nome` departamento
			,mcd.`ativo`
			,mcd.`periodo`
FROM assoc_membros_cargos_departamentos mcd
LEFT JOIN membros m
	ON mcd.`membro_id` = m.`id`
 AND mcd.`empresa_id` = m.`empresa_id`
LEFT JOIN cargos c
	ON mcd.`cargo_id` = c.`id`
 AND mcd.`empresa_id` = c.`empresa_id`
LEFT JOIN departamentos d
	ON mcd.`departamento_id` = d.`id`
 AND mcd.`empresa_id` = d.`empresa_id`
WHERE mcd.`empresa_id` = 1
	AND mcd.`cargo_id` = 1
	AND mcd.`departamento_id` = 10
	AND mcd.ativo = 'S';