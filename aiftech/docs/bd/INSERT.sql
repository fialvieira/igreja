START TRANSACTION;
INSERT INTO enderecos (cep, logradouro, bairro, localidade, estado_id, user_id, created, modified)
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
SELECT LAST_INSERT_ID() AS ID       