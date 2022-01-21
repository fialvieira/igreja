DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `membro_agenda_enderecos_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_agenda_enderecos_sel`(
	vempresa 	INT(11),
	vstatus 	CHAR(1),
	vquorum		CHAR(1),
	vendereco	CHAR(1)		
)
BEGIN
	IF vendereco IS NULL THEN
		SELECT m.`nome`
					/*,tr.`descricao`
					,(SELECT nome
						FROM membros mem
						LEFT JOIN relacionamentos rel
							ON mem.id = rel.membro2_id
						 AND mem.empresa_id = rel.empresa_id
						 WHERE rel.membro_id = m.`id`) nome1*/
					,CASE
						WHEN UPPER(SUBSTRING(e.`logradouro`, 1, 3)) = 'RUA' THEN
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 5, 1)))
						ELSE
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 1, 1)))
					 END letra
					,e.`logradouro`
					,m.`enderecos_numero`
					,m.`enderecos_complemento`
					,e.`cep`
		FROM membros m
		LEFT JOIN membros_frequencia mf
			 ON m.frequencia_id = mf.id
			AND m.empresa_id = mf.`empresa_id`
		/*LEFT JOIN relacionamentos r
			ON m.`id` = r.`membro_id`
		 AND m.`empresa_id` = r.`empresa_id`
		LEFT JOIN tipo_relacionamentos tr
			ON r.`tiporelacionamento_id` = tr.`id`*/
		LEFT JOIN enderecos e
					 ON m.enderecos_id = e.`id`
		LEFT JOIN estados T2
					 ON e.estado_id = T2.id
		WHERE m.`empresa_id` = vempresa
			AND mf.status = IFNULL(vstatus, mf.`status`)
			AND mf.quorum = IFNULL(vquorum, mf.`quorum`)
		ORDER BY letra, e.logradouro, m.`enderecos_numero`, m.`enderecos_complemento`;
	ELSEIF vendereco = 'S' THEN
		SELECT m.`nome`
					/*,tr.`descricao`
					,(SELECT nome
						FROM membros mem
						LEFT JOIN relacionamentos rel
							ON mem.id = rel.membro2_id
						 AND mem.empresa_id = rel.empresa_id
						 WHERE rel.membro_id = m.`id`) nome1*/
					,CASE
						WHEN UPPER(SUBSTRING(e.`logradouro`, 1, 3)) = 'RUA' THEN
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 5, 1)))
						ELSE
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 1, 1)))
					 END letra
					,e.`logradouro`
					,m.`enderecos_numero`
					,m.`enderecos_complemento`
					,e.`cep`
		FROM membros m
		LEFT JOIN membros_frequencia mf
			 ON m.frequencia_id = mf.id
			AND m.empresa_id = mf.`empresa_id`
		/*LEFT JOIN relacionamentos r
			ON m.`id` = r.`membro_id`
		 AND m.`empresa_id` = r.`empresa_id`
		LEFT JOIN tipo_relacionamentos tr
			ON r.`tiporelacionamento_id` = tr.`id`*/
		LEFT JOIN enderecos e
					 ON m.enderecos_id = e.`id`
		LEFT JOIN estados T2
					 ON e.estado_id = T2.id
		WHERE m.`empresa_id` = vempresa
			AND mf.`status` = IFNULL(vstatus, mf.`status`)
			AND mf.`quorum` = IFNULL(vquorum, mf.`quorum`)
			AND e.`id` IS NOT NULL
		ORDER BY letra, e.logradouro, m.`enderecos_numero`, m.`enderecos_complemento`;
	ELSE
		SELECT m.`nome`
					/*,tr.`descricao`
					,(SELECT nome
						FROM membros mem
						LEFT JOIN relacionamentos rel
							ON mem.id = rel.membro2_id
						 AND mem.empresa_id = rel.empresa_id
						 WHERE rel.membro_id = m.`id`) nome1*/
					,CASE
						WHEN UPPER(SUBSTRING(e.`logradouro`, 1, 3)) = 'RUA' THEN
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 5, 1)))
						ELSE
							UPPER(fn_remove_accents(SUBSTRING(e.`logradouro`, 1, 1)))
					 END letra
					,e.`logradouro`
					,m.`enderecos_numero`
					,m.`enderecos_complemento`
					,e.`cep`
		FROM membros m
		LEFT JOIN membros_frequencia mf
			 ON m.frequencia_id = mf.id
			AND m.empresa_id = mf.`empresa_id`
		/*LEFT JOIN relacionamentos r
			ON m.`id` = r.`membro_id`
		 AND m.`empresa_id` = r.`empresa_id`
		LEFT JOIN tipo_relacionamentos tr
			ON r.`tiporelacionamento_id` = tr.`id`*/
		LEFT JOIN enderecos e
					 ON m.enderecos_id = e.`id`
		LEFT JOIN estados T2
					 ON e.estado_id = T2.id
		WHERE m.`empresa_id` = vempresa
			AND mf.status = IFNULL(vstatus, mf.`status`)
			AND mf.quorum = IFNULL(vquorum, mf.`quorum`)
			AND e.`id` IS NULL
		ORDER BY letra, e.logradouro, m.`enderecos_numero`, m.`enderecos_complemento`;
	END IF;
END$$

DELIMITER ;