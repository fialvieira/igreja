UPDATE membros m
LEFT JOIN membros_frequencia mf
	ON m.frequencia_id = mf.id
LEFT JOIN estados e
	ON m.estado_id = e.id
LEFT JOIN escolaridades es
	ON m.escolaridade_id = es.id
LEFT JOIN pastores p
	ON m.pastorbatismo = p.id
LEFT JOIN LOCAL l
	ON m.`local_id` = l.`id`
SET membros_ft = CONCAT_WS(' '
			      ,fn_remove_accents(m.nome)
			      ,m.nome
			      ,m.cpf
			      ,m.email
			      ,IFNULL(mf.frequencia, '')
			      ,CASE
				WHEN m.sexo = 'M' THEN 'Masculino'
				WHEN m.sexo = 'F' THEN 'Feminino'
			       END
			       ,DATE_FORMAT(datanascimento, '%d/%m/%Y')
			       ,IFNULL(e.sigla, '')
			       ,CASE IFNULL(m.estadocivil, '')
				 WHEN '' THEN ''
				 ELSE CASE
					WHEN m.estadocivil = 0 THEN 'Solteiro(a)'
					WHEN m.estadocivil = 1 THEN 'Casado(a)'
					WHEN m.estadocivil = 2 THEN 'Divorciado(a)'
					WHEN m.estadocivil = 3 THEN 'Viúvo(a)'
					WHEN m.estadocivil = 4 THEN 'Separado(a)'
				      END
				END
			       ,IFNULL(m.rg, '')
			       ,IFNULL(m.fone, '')
			       ,IFNULL(m.cel, '')
			       ,IFNULL(es.descricao, '')
			       ,IFNULL(p.nome, '')
			       ,IFNULL(l.`nome`, '')
		          )
WHERE membros_ft IS NULL;