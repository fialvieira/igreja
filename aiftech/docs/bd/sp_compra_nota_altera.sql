DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `compra_nota_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `compra_nota_altera`(
	vid 			INT(11) UNSIGNED,
	vdata_nota 		DATE,
	vnumero_nota		VARCHAR(20),
	vvalor_nota		DECIMAL(10,2),
	vobservacao		TEXT,
	vqtd_parcelas		INT(5),
	vmeio_pagamento_id	INT(11) UNSIGNED,
	vpath_nota		VARCHAR(250),
	vuser_id 		INT(11),
	vempresa_id 		INT(11),
	vmodified 		DATETIME
)
BEGIN
	UPDATE compras
	SET data_nota = IFNULL(vdata_nota, data_nota),
	    valor_nota = IFNULL(vvalor_nota, valor_nota),
	    numero_nota = IFNULL(vnumero_nota, numero_nota),
	    observacao = IFNULL(vobservacao, observacao),
	    qtd_parcelas = IFNULL(vqtd_parcelas, qtd_parcelas),
	    meio_pagamento_id = IFNULL(vmeio_pagamento_id, meio_pagamento_id),
	    path_nota = IFNULL(vpath_nota, path_nota),
	    user_id = vuser_id,
	    modified = vmodified
	WHERE id = vid
	  AND empresa_id = vempresa_id;
END$$

DELIMITER ;