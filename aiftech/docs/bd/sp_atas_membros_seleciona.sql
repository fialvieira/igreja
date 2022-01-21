DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `atas_membros_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atas_membros_seleciona`(
	vempresa INT(11),
	vativo	 CHAR(1),
	vlimit   INT,
	vorder   VARCHAR(100)
)
BEGIN
	SELECT COUNT(*) INTO @rec FROM membros;
	
	SET vlimit = IFNULL(vlimit,@rec);
	IF vativo IS NULL THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum,
		       c.nome cargo_nome, 
		       d.nome dep_nome
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
        LEFT JOIN assoc_membros_cargos_departamentos mcd
					 ON T1.id = mcd.membro_id
				  AND mcd.ativo = 'S'
        LEFT JOIN cargos c
					 ON mcd.cargo_id = c.id  
        LEFT JOIN departamentos d
					 ON mcd.departamento_id = d.id	       
		WHERE T1.empresa_id = vempresa
		ORDER BY CASE 
                    WHEN vorder = 'modified' THEN 
                        T1.modified 
                    ELSE '' 
                  END DESC, T1.nome  
		LIMIT vlimit;
	ELSEIF vativo = 'S' THEN
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum,
		       c.nome cargo_nome, 
		       d.nome dep_nome
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		LEFT JOIN membros_frequencia mf
		       ON T1.frequencia_id = mf.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
        LEFT JOIN assoc_membros_cargos_departamentos mcd
			   ON T1.id = mcd.membro_id
			  AND mcd.ativo = 'S'
        LEFT JOIN cargos c
		       ON mcd.cargo_id = c.id  
        LEFT JOIN departamentos d
			   ON mcd.departamento_id = d.id     
		WHERE T1.empresa_id = vempresa
		  AND mf.status = 'A'
		ORDER BY CASE 
                    WHEN vorder = 'modified' THEN 
                        T1.modified 
                    ELSE '' 
                  END DESC, T1.nome  
		LIMIT vlimit;
	ELSE
		SELECT T1.*,
		       T2.sigla estado_descricao,
		       T3.descricao escolaridade_descricao,
		       T4.nome profissoe_descricao,
		       ps.idade_quorum,
		       c.nome cargo_nome, 
		       d.nome dep_nome
		FROM membros T1
		LEFT JOIN estados T2
		       ON T1.estado_id = T2.id
		LEFT JOIN escolaridades T3
		       ON T1.escolaridade_id = T3.id
		LEFT JOIN profissoes T4
		       ON T1.profissao_id = T4.id
		LEFT JOIN membros_frequencia mf
		       ON T1.frequencia_id = mf.id
		INNER JOIN parametros_sistema ps
		       ON T1.empresa_id = ps.empresa_id
        LEFT JOIN assoc_membros_cargos_departamentos mcd
               ON T1.id = mcd.membro_id
			  AND mcd.ativo = 'S'
        LEFT JOIN cargos c
               ON mcd.cargo_id = c.id  
        LEFT JOIN departamentos d
               ON mcd.departamento_id = d.id	       
		WHERE T1.empresa_id = vempresa
		  AND mf.status <> 'A'
		ORDER BY CASE WHEN vorder = 'modified' THEN 
                        T1.modified 
                      ELSE '' 
                  END DESC, T1.nome  
		LIMIT vlimit;
	END IF;
END$$

DELIMITER ;