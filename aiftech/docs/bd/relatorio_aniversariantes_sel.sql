DELIMITER $$

CREATE
    /*[DEFINER = { user | CURRENT_USER }]*/
    PROCEDURE `igreja`.`relatorio_aniversariantes_sel`(
				vempresa_id INT(11)
			 ,vmes				INT(2)
    )
    BEGIN
    
			SELECT tbl.*
			FROM (SELECT  m.nome,
										m.datanascimento,
										CAST(CONCAT(CAST(YEAR(CURDATE()) AS CHAR), '-',  LPAD(CAST(MONTH(m.datanascimento) AS CHAR), 2, 0), '-', LPAD(CAST(DAY(m.datanascimento) AS CHAR), 2, 0)) AS DATE) aniversario,
										CASE DAYNAME(CAST(CONCAT(CAST(YEAR(CURDATE()) AS CHAR), '-',  LPAD(CAST(MONTH(m.datanascimento) AS CHAR), 2, 0), '-', LPAD(CAST(DAY(m.datanascimento) AS CHAR), 2, 0)) AS DATE))
												WHEN 'Monday'     THEN 'Segunda-feira'
												WHEN 'Tuesday'    THEN 'Terça-feira'
												WHEN 'Wednesday'  THEN 'Quarta-feira'
												WHEN 'Thursday'   THEN 'Quinta-feira'
												WHEN 'Friday'     THEN 'Sexta-feira'
												WHEN 'Saturday'   THEN 'Sábado'
												WHEN 'Sunday'     THEN 'Domingo'
										END dia,
										TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) idade
						FROM membros m
						INNER JOIN membros_frequencia mf
						ON m.frequencia_id = mf.id
						WHERE m.empresa_id = vempresa_id
							AND MONTH(m.datanascimento) = vmes
							AND m.`datanascimento` <> '2016-01-01'
							AND mf.status = 'A') tbl
			ORDER BY tbl.aniversario;
			
    END$$
    
DELIMITER ;