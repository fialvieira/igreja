<?php

$params = '';
$params_altera = '';
$params_insert = '';
$where = '';
$update = '';
$insert_fields = '';
$insert_params = '';
$select_insert = '';
$where_full = '';
$fields_relaciona = '';
$inner = '';
$param_ativo = '';
$filtro_ativo = '';
$i = 2;
foreach ($campos as $campo) {
  switch ($campo["TIPO"]) {
    case 'inteiro':
      $tamanho = '('.$campo["TAMANHO_NUM"].')';
      break;
    case 'real':
      $tamanho = '('.$campo["TAMANHO_NUM"].','.$campo["CASA_DECIMAL"].')';
      break;
    case 'texto':
      $tamanho = '('.$campo["TAMANHO_TEXTO"].')';
      break;
    default:
      $tamanho = '';
      break;
  }
  $params_altera .= 'v' . $campo["CAMPO"] . ' '. strtoupper($campo["COLUMN_TYPE"]) . ',
        '; 
  if ($campo["CHAVE"] == "PRI") {  
    $params .= 'v' . $campo["CAMPO"] . ' '. strtoupper($campo["COLUMN_TYPE"]) . ',
        '; 
    $where .= $campo["CAMPO"] . ' = '. 'v' . $campo["CAMPO"] .'
        AND ';
    $auto = '';
    if ($campo['AUTO_INCREMENTO'] == 'S') {
        $auto = 'LAST_INSERT_ID() ';
    }
    $select_insert .= $auto.$campo["CAMPO"].',';
  } else {
    $update .= $campo["CAMPO"].' = v'.$campo["CAMPO"].',
	';
    $params_insert .= 'v' . $campo["CAMPO"] . ' '. strtoupper($campo["COLUMN_TYPE"]) . ',
        '; 
    $insert_fields .= $campo["CAMPO"].', ';
    $insert_params .= 'v'.$campo["CAMPO"].', ';
    
  }
  $ret_key = false;
  if ($foreign_key) {
     $ret_key = $foreign_key[array_search($campo["CAMPO"], array_column($foreign_key, 'COLUMN_NAME'))]; 
  }
  
  if ($campo["CHAVE"] == "MUL" && $ret_key === false) {
    $where_full = 'MATCH('.$campo["CAMPO"].') AGAINST(CONCAT("\'", vpar, "*", "\'") IN BOOLEAN MODE)';
  }
  $desc = '';
  if ($campo["RELACIONA_TABELA"] != ""){
    $ret_relaciona = $relaciona_modelo[array_search($campo["RELACIONA_TABELA"], array_column($relaciona_modelo, 'nome'))];
    if ($ret_relaciona !== false) {
        $desc = str_replace(' ','_',strtolower($ret_relaciona['modelo'])).'_descricao';
        $fields_relaciona .= ', T'.$i.'.'.$ret_relaciona['descricao'].' '.$desc;
        $inner .= 'LEFT JOIN '.$ret_relaciona['nome'].' T'.$i.'
               ON T1.'.$campo["CAMPO"].' = T'.$i.'.'.$ret_relaciona['id'].'
        ';
        $i++;
    }
  }
  if($campo["CAMPO"] == 'ativo'){
    $param_ativo = 'vativo CHAR(1),';
    $filtro_ativo = ' AND IFNULL(T1.ativo,"") = CASE WHEN vativo = "T" THEN IFNULL(T1.ativo,"")
                                      ELSE vativo
					END';
  }
}
$params = substr($params,0,-11);
$params_altera = substr($params_altera,0,-11);
$params_insert = substr($params_insert,0,-11);
$where = substr($where,0,-14);
$update = substr($update,0,-4);
$insert_fields = substr($insert_fields,0,-2);
$insert_params = substr($insert_params,0,-2);
$select_insert = substr($select_insert,0,-1);

$sql = 
'/*** PROCEDURE SELECIONA REGISTRO ***/
DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `'.$nome_tabela.'_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `'.$nome_tabela.'_seleciona`(
	'.$params.'
)
BEGIN
	SELECT *
	FROM '.$tabela['tabela'].' 
	WHERE '.$where.';
END$$

DELIMITER ;

/*** PROCEDURE ALTERA ***/
DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `'.$nome_tabela.'_altera`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `'.$nome_tabela.'_altera`(
	'.$params_altera.'
)
BEGIN
	UPDATE '.$tabela['tabela'].'
	SET
	'.$update.'
	WHERE '.$where.';
END$$

DELIMITER ;

/*** PROCEDURE INSERT ***/
DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `'.$nome_tabela.'_insere`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `'.$nome_tabela.'_insere`(
	'.$params_insert.'
)
BEGIN
	INSERT INTO '.$tabela['tabela'].'
	('.$insert_fields.')
	VALUES
	('.$insert_params.');
	SELECT '.$select_insert.';
END$$

DELIMITER ;

/*** PROCEDURE SELECIONA TODOS ***/
DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `'.$tabela['tabela'].'_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `'.$tabela['tabela'].'_seleciona`(
  '.$param_ativo.'
	vempresa INT(11)
)
BEGIN
	SELECT T1.*'.$fields_relaciona.'
	FROM '.$tabela['tabela'].' T1
        '.$inner.'
        WHERE T1.empresa_id = vempresa'.$filtro_ativo.';
END$$

DELIMITER ;
';
if ($where_full != '') {
  $sql .= 
'/*** PROCEDURE SELECIONA FULLTEXT ***/
DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `'.$tabela['tabela'].'_fulltext_seleciona`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `'.$tabela['tabela'].'_fulltext_seleciona`(
	      vpar TEXT(10000),
        vempresa INT(11)
)
BEGIN
        SELECT T1.*'.$fields_relaciona.'
        FROM '.$tabela['tabela']. ' T1
        '.$inner.'
        WHERE empresa_id = vempresa AND '.$where_full.';
ND$$

DELIMITER ;

';  
}

$dir = RAIZ . 'docs/script/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new \Exception('Falha ao criar diretório do arquivo' . basename($dir) . '!!');
    }
} 

//--------> html
$dir = RAIZ . 'docs/script/' . $tabela['tabela'] . '_procedures.sql';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $sql);
if ($fw != strlen($sql)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}


