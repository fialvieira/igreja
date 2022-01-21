SELECT amc.membro_id
      ,amc.cargo_id
      ,amc.departamento_id
      ,dep.nome departamento
      ,car.nome cargo
      ,amc.ativo
      ,amc.periodo
FROM assoc_membros_cargos_departamentos amc
INNER JOIN membros mem
	ON amc.membro_id = mem.id
       AND amc.empresa_id = mem.empresa_id
INNER JOIN cargos car
	ON amc.cargo_id = car.id
       AND amc.empresa_id = car.empresa_id
INNER JOIN departamentos dep
	ON amc.departamento_id = dep.id
       AND amc.empresa_id = dep.empresa_id
WHERE amc.empresa_id = 1
  AND amc.membro_id = 1
ORDER BY amc.ativo DESC