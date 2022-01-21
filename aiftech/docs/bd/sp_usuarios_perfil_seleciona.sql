DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `usuarios_perfil_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `usuarios_perfil_seleciona`(
	vchurchs_id	INT(11),
	vativo		CHAR(1),
	vperfil		TINYINT(4)
)
BEGIN
	IF vativo IS NULL THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE chu.id = vchurchs_id
		  AND usr.perfil = IFNULL(vperfil, usr.perfil)
		ORDER BY usr.nome;
	ELSEIF vativo = 'S' THEN
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE usr.ativo = 'S'
		  AND chu.id = vchurchs_id
		  AND usr.perfil = IFNULL(vperfil, usr.perfil)
		ORDER BY usr.nome;
	ELSE
		SELECT usr.*
		FROM users usr
		INNER JOIN assoc_empresas_users acu
			ON usr.id = acu.users_id
		INNER JOIN empresas chu
			ON acu.empresa_id = chu.id
		WHERE usr.ativo <> 'S'
		  AND usr.ativo IS NOT NULL
		  AND chu.id = vchurchs_id
		  AND usr.perfil = IFNULL(vperfil, usr.perfil)
		ORDER BY usr.nome;
	END IF;
END$$

DELIMITER ;