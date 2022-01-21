UPDATE membro
SET MEM_CEP = REPLACE(MEM_CEP, '.', ''),
    MEM_CEP = REPLACE(MEM_CEP, '-', ''),
    MEM_CEP = REPLACE(MEM_CEP, ' ', '');