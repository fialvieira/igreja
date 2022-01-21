START TRANSACTION;
INSERT INTO `igreja`.`membros` (
  `frequencia_id`,
  `foto`,
  `nome`,
  `sexo`,
  `datanascimento`,
  `naturalidade`,
  `estado_id`,
  `data_casamento`,
  `rg`,
  `orgao_emissor`,
  `data_expedicao`,
  `cpf`,
  `email`,
  `fone`,
  `cel`,
  `escolaridade_id`,
  `empresa`,
  `empresa_id`,
  `enderecos_id`,
  `enderecos_numero`,
  `enderecos_complemento`,
  `created`,
  `modified`,
  `tipo`,
  `estadocivil`,
  `local_id`
)
SELECT  m.FK_MEM_STATUS_FREQ_COD,
	m.MEM_FOTO,
	m.MEM_NOM,
	m.MEM_SEXO,
	m.MEM_DT_NASC,
	c.NOM_CID,
	e.id estado_id,
	m.MEM_DT_CAS,
	m.MEM_RG,
	m.MEM_RG_ORGAO_EXP,
	m.MEM_DT_RG,
	m.MEM_CPF,
	m.MEM_EMAIL_1,
	m.MEM_TEL,
	m.MEM_CEL1,
	m.MEM_GRAU_INSTRU,
	m.MEM_EMP_TRABALHA,
	1,
	en.id,
	m.MEM_NRO,
	m.MEM_COMPLEMENTO,
	'2018-01-20 14:20:00',
	'2018-01-20 14:20:00',
	'M',
	CASE
		WHEN m.MEM_EST_CIVIL = 'Casado(a)' THEN 1
		WHEN m.MEM_EST_CIVIL = 'Solteiro(a)' THEN 0
		WHEN m.MEM_EST_CIVIL = 'Viúvo(a)' THEN 3
		WHEN m.MEM_EST_CIVIL = 'Divorciado(a)' THEN 2
		WHEN m.MEM_EST_CIVIL = 'Separado(a)' THEN 4
		ELSE NULL
        END,
        m.MEM_FK_CON_COD
FROM membro m
LEFT JOIN cidade c
	ON m.MEM_FK_CID_COD_NAT = c.PK_CID_COD
LEFT JOIN estados e
	ON c.`UF_CID` = e.`sigla`
LEFT JOIN enderecos en
	ON m.`MEM_CEP` = en.`cep`;
	
	
	
	

ROLLBACK;	

COMMIT;