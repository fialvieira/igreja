SELECT T1.`nome`,
			 fn_remove_accents(SUBSTRING(T1.`nome`, 1, 1)) letra,
			 T1.`fone`,
			 T1.`cel`,
			 T1.`email`,
			 T2.sigla estado,
			 e.`cep`,
			 e.`logradouro`,
			 T1.`enderecos_numero`,
			 e.`bairro`,
			 e.`localidade` municipio,
			 T1.`enderecos_complemento`,
			 l.`nome` `local`
FROM membros T1
LEFT JOIN `local` l
			 ON T1.`local_id` = l.`id`
			AND T1.`empresa_id` = l.`empresa_id` 
LEFT JOIN membros_frequencia mf
			 ON T1.frequencia_id = mf.id
LEFT JOIN enderecos e
			 ON T1.enderecos_id = e.`id`
LEFT JOIN estados T2
			 ON e.estado_id = T2.id
WHERE T1.empresa_id = 1
  AND mf.status = IFNULL('A', mf.`status`)
  AND mf.quorum = IFNULL(NULL, mf.`quorum`)
  AND T1.`local_id` = IFNULL(NULL, T1.`local_id`)
ORDER BY e.`logradouro`, T1.`enderecos_numero`