DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membro_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membro_altera`(
				vid 										INT(11) UNSIGNED,
        vfrequencia 						INT(11),
        vnome 									VARCHAR(100),
        vsexo 									CHAR(1),
        vdatanascimento 				DATE,
        vnaturalidade 					VARCHAR(100),
        vestado_id 							INT(11) UNSIGNED,
        vestadocivil 						INT(11),
        vlatitude 							VARCHAR(50),
        vlongitude 							VARCHAR(50),
        vrg 										VARCHAR(20),
        vorgao_emissor 					VARCHAR(20),
        vdata_expedicao 				DATE,
        vcpf 										VARCHAR(20),
        vemail 									VARCHAR(150),
        vfone 									VARCHAR(20),
        vcel 										VARCHAR(20),
        vescolaridade_id 				INT(11) UNSIGNED,
        vprofissao_id 					INT(11) UNSIGNED,
        vempresa 								VARCHAR(150),
        vdatabatismo 						DATE,
        vigrejabatismo 					INT(11),
        vpastorbatismo 					INT(11),
        vultimaigreja 					INT(11),
        vdatamembro 						DATE,
        vcargo_id 							INT(11) UNSIGNED,
        vempresa_id 						INT(11),
        venderecos_id						INT(11),
        venderecos_numero				VARCHAR(45),
        venderecos_complemento	VARCHAR(256),
        vuser_id 								INT(11),
        vcreated 								DATETIME,
        vmodified 							DATETIME,
        vtipo 									CHAR(1),
        vdata_casamento					DATE,
        vlocal_id								INT(11) UNSIGNED,
        vata_batismo						INT(11) UNSIGNED
)
BEGIN
	UPDATE membros
	SET
	frequencia_id = vfrequencia,
	nome = vnome,
	sexo = vsexo,
	datanascimento = vdatanascimento,
	naturalidade = vnaturalidade,
	estado_id = vestado_id,
	estadocivil = vestadocivil,
	data_casamento = vdata_casamento,
	latitude = vlatitude,
	longitude = vlongitude,
	rg = vrg,
	orgao_emissor = vorgao_emissor,
  data_expedicao = vdata_expedicao,
	cpf = vcpf,
	email = vemail,
	fone = vfone,
	cel = vcel,
	escolaridade_id = vescolaridade_id,
	profissao_id = vprofissao_id,
	empresa = vempresa,
	databatismo = vdatabatismo,
	igrejas_id = vigrejabatismo,
	pastorbatismo = vpastorbatismo,
	ultimaigreja = vultimaigreja,
	datamembro = vdatamembro,
	cargo_id = vcargo_id,
	empresa_id = vempresa_id,
	enderecos_id = venderecos_id,
	enderecos_numero = venderecos_numero,
	enderecos_complemento = venderecos_complemento,
	user_id = vuser_id,
	created = vcreated,
	modified = vmodified,
	tipo = vtipo,
	local_id = vlocal_id,
	ata_batismo = vata_batismo
	WHERE id = vid;
END$$

DELIMITER ;