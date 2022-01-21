START TRANSACTION;
INSERT INTO `igreja`.`membros` (
  `frequencia_id`,
  `foto`,
  `nome`,
  `sexo`,
  `datanascimento`,
  `naturalidade`,
  `estado_id`,
  `estadocivil`,
  `data_casamento`,
  `latitude`,
  `longitude`,
  `rg`,
  `orgao_emissor`,
  `data_expedicao`,
  `cpf`,
  `email`,
  `fone`,
  `cel`,
  `escolaridade_id`,
  `profissao_id`,
  `empresa`,
  `databatismo`,
  `igrejas_id`,
  `pastorbatismo`,
  `ultimaigreja`,
  `datamembro`,
  `cargo_id`,
  `empresa_id`,
  `enderecos_id`,
  `enderecos_numero`,
  `enderecos_complemento`,
  `user_id`,
  `created`,
  `modified`,
  `tipo`,
  `membros_ft`
)
SELECT cp.cep,
       cp.logradouro,	
       cp.bairro,
       ct.cidade,
       es.id,
       1,
       '2018-01-18 13:30:00',
       '2018-01-18 13:30:00'
FROM ceps cp
INNER JOIN cities ct
	ON cp.cities_id = ct.id
INNER JOIN states st
	ON cp.states_id = st.id
       AND ct.states_id = st.id
 INNER JOIN estados es
	ON st.sigla = es.sigla;

ROLLBACK;	

COMMIT;