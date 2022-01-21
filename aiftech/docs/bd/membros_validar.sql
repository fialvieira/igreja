SELECT nome
			,CASE
					WHEN datanascimento = '2016-01-01' THEN 'Data de nascimento não cadastrada'
					ELSE datanascimento
			 END datanascimento
			,CASE
					WHEN cpf IS NULL THEN 'CPF não cadastrado'
					WHEN cpf = '' THEN 'CPF não cadastrado'
				  ELSE cpf
			 END cpf
			,IFNULL(sexo, 'Sexo não cadastrado') sexo
			,IFNULL(enderecos_id, 'Endereço não cadastrado') endereco
			,IFNULL(email, 'E-mail não cadastrado') email
FROM membros
WHERE empresa_id = 1
   OR datanascimento = '2016-01-01'
	 OR (cpf IS NULL OR cpf = '')
	 OR LENGTH(nome) < 3
	 OR sexo IS NULL
	 OR enderecos_id IS NULL
	 OR email IS NULL
ORDER BY nome