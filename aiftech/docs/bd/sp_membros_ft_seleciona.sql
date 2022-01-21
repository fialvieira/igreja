DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membros_ft_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_ft_seleciona`(
	vpar 		TEXT(10000),
	vempresa_id	INT(11),
	vativo		CHAR(1)
)
BEGIN
	IF vativo IS NULL THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		WHERE T1.membros_ft LIKE CONCAT('%', vpar, '%')
		  AND T1.empresa_id = vempresa_id
		ORDER BY T1.nome;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		INNER JOIN membros_frequencia MF
					 ON T1.frequencia_id = MF.id
					AND T1.empresa_id = MF.empresa_id
		WHERE T1.membros_ft LIKE CONCAT('%', vpar, '%')
		  AND T1.empresa_id = vempresa_id
		  AND MF.status = 'A'
		ORDER BY T1.nome;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
		INNER JOIN membros_frequencia MF
					 ON T1.frequencia_id = MF.id
					AND T1.empresa_id = MF.empresa_id
		WHERE T1.membros_ft LIKE CONCAT('%', vpar, '%')
		  AND T1.empresa_id = vempresa_id
		  AND MF.status <> 'A'
		ORDER BY T1.nome;
	END IF;
END$$

DELIMITER ;