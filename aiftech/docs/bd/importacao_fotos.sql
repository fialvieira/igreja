SELECT *
FROM membros
WHERE nome LIKE 'Romulo%'

UPDATE membros
SET foto = CONCAT('arquivos/empresa_id_1/fotos/', CAST(id AS CHAR), '.jpg')
WHERE foto IS NOT NULL 
  AND foto <> '';