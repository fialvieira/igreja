DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `cargo_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cargo_altera`(
	vid INT(11) UNSIGNED,
        vnome VARCHAR(45),
        vdescricao TEXT,
        vabreviacao VARCHAR(30),
        vtipo_comissao CHAR(1),
        vuser_id INT(11) UNSIGNED,
        vcreated DATETIME,
        vmodified DATETIME
)
BEGIN
	UPDATE cargos
	SET
	nome = vnome,
	descricao = vdescricao,
	abreviacao = vabreviacao,
	tipo_comissao = vtipo_comissao,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified
	WHERE id = vid;
END$$

DELIMITER ;