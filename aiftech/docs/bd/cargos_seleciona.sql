DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `cargos_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cargos_seleciona`(
				vativo CHAR(1),
        vempresa INT(11)
)
BEGIN
	SELECT T1.*
				,CASE WHEN tipo_comissao = 'E' THEN 'Estatutária'
							WHEN tipo_comissao = 'O' THEN 'Outras'
							ELSE ''
				 END tipo_comissao_descricao
	FROM cargos T1
	WHERE T1.empresa_id = vempresa
		 AND IFNULL(T1.ativo,"") = CASE 
																WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
																ELSE vativo
															 END
	ORDER BY T1.nome;
END$$

DELIMITER ;