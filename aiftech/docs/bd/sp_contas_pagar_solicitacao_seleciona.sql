DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `contas_pagar_solicitacao_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contas_pagar_solicitacao_seleciona`(
	vempresa INT(11),
	vsolicitante INT(11) UNSIGNED,
	vdata_ini DATETIME,
	vdata_fim DATETIME
)
BEGIN
	SELECT C.*
	      ,CASE
		WHEN C.situacao = 'S' THEN 'Solicitado'
		WHEN C.situacao = 'A' THEN 'Aprovado'
		WHEN C.situacao = 'R' THEN 'Recusado'
		WHEN C.situacao = 'P' THEN 'Pré-Aprovado'
		ELSE 'Executado'
	       END situacao_descricao
	      ,S.nome solicitante_nome
	      ,A.nome autorizador_nome
	FROM compras C
	INNER JOIN membros S
		ON C.solicitante_id = S.id
	 AND C.empresa_id = S.empresa_id
	LEFT JOIN membros A
		ON C.autorizador_id = A.id
	 AND C.empresa_id = A.empresa_id
	WHERE C.empresa_id = vempresa
		AND C.data_solicitacao BETWEEN vdata_ini AND vdata_fim
		AND C.situacao IN ('A', 'E')
		AND C.solicitante_id = IFNULL(vsolicitante, C.solicitante_id);
END$$

DELIMITER ;