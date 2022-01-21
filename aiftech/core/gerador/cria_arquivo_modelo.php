<?php
$php = 
'<?php

namespace modelo;

use bd\My;

class '.$modelo.' {
';

foreach ($campos as $campo) {
//  $php .= '  private $'. str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).';
//';
  $php .= '  private $'. $campo["CAMPO"] .';
';
}

$php .=
'
  /**
   * '.$modelo.' constructor. 
   * @param ';

$params = '';
$params_null = '';
$if_params = '';
$if_params_salva = '';
foreach ($campos as $campo) {
  if ($campo["CHAVE"] == "PRI") {  
    $php .= '$'. $campo["CAMPO"] .',';
    $params .= '$' . $campo["CAMPO"] . ','; 
    $params_null .= '$' . $campo["CAMPO"] . ' = null,'; 
    $if_params .= '!is_null($' . $campo["CAMPO"] . ') &&'; 
    $if_params_salva .= '$this->' . $campo["CAMPO"] . ' &&'; 
  }  
}
$params = substr($params,0,-1);
$params_null = substr($params_null,0,-1);
$if_params = substr($if_params,0,-3);
$if_params_salva = substr($if_params_salva,0,-3);

$php = substr($php,0,-1);
$php .=
'  
   * @throws \Exception
   */
  public function __construct('.$params_null.') {
    if ('.$if_params.') {
';
foreach ($campos as $campo) :
  if ($campo["CHAVE"] == "PRI") {  
    $formato_tipo = \gerador\Gerador::TipoFormato($campo["TIPO"], 'bd');
    if ($formato_tipo != '') {
        $valor = $formato_tipo.'$'.$campo["CAMPO"].')';
    } else {
        $valor = '$"'.$campo["CAMPO"].'';
    }
    $php .= '      $'.$campo["CAMPO"].' = '.$valor.';
';
  }
endforeach;

$php .='      $c = My::con();
      $r = $c->query("CALL '.$nome_tabela.'_seleciona('.$params.')");
      $l = $r->fetch_assoc();
      if ($l) { 
';

foreach ($campos as $campo) {
  if ($campo["CHAVE"] == "PRI") {  
    $php .= '        $this->'. $campo["CAMPO"] .' = $'. $campo["CAMPO"] .';
';
  } else {
    $php .= '        $this->'. $campo["CAMPO"] .' = $l["'. $campo["CAMPO"] .'"];
';
 }  
}

$php.='      }
      $c->next_result();
    }
  }
';

foreach ($campos as $campo) {
  $formato_tipo_app = \gerador\Gerador::TipoFormato($campo["TIPO"], 'app');
  if ($formato_tipo_app != '') {
    $valor_app = $formato_tipo_app.'$this->'.$campo["CAMPO"].')';
  } else {
    $valor_app = '$this->'.$campo["CAMPO"].'';
  }
  $formato_tipo_bd = \gerador\Gerador::TipoFormato($campo["TIPO"], 'bd');
  if ($formato_tipo_bd != '') {
    $valor_bd = $formato_tipo_bd.'$'.$campo["CAMPO"].')';
  } else {
    $valor_bd = '$'.$campo["CAMPO"].'';
  }
    
  $php .= 
'  /**
  * @return mixed
  */
  public function get'.str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).'() {
    return '.$valor_app.';
  }
  
  /**
   * @param mixed $'.$campo["CAMPO"].'
   */
  public function set'.str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).'($'.$campo["CAMPO"].') {
    $this->'.$campo["CAMPO"].' = '.$valor_bd.';
  }

';
}

$php .=
'  public function salva() {
    $c = My::con();
';

$chave_primaria = '';
$qtde_params_altera = '';
$qtde_params_insert = '';
$tipo_params_altera = '';
$tipo_params_insert = '';
$params_altera = '';
$params_insert = '';
foreach ($campos as $campo) {
  if ($campo["OBRIGATORIO"] == "S" && $campo["CHAVE"] != "PRI") {  
    $php .= 
    '    if (!$this->'.$campo["CAMPO"].') {
      throw new \Exception("'.ucwords(str_replace("_", " ", $campo["CAMPO"])).' obrigatório(a).");
    }

';
  }  
  if ($campo["CHAVE"] == "PRI") {  
    $chave_primaria .= '$this->'.$campo["CAMPO"].' = $l["'.$campo["CAMPO"].'"];
      ';
  }
  
//para procedure de alteracao  
  $qtde_params_altera .= '?,';
  switch ($campo['TIPO']) {
      case 'inteiro':
          $tipo_params_altera .= 'i';
          break;
      case 'real':
          $tipo_params_altera .= 'd';
          break;
      default:
          $tipo_params_altera .= 's';
          break;
  }
  $params_altera .= '$this->'.$campo["CAMPO"].',
              ';
//para procedure de insert  
  if ($campo["AUTO_INCREMENTO"] != "S") {
    switch ($campo['TIPO']) {
        case 'inteiro':
            $tipo_params_insert .= 'i';
            break;
        case 'real':
            $tipo_params_insert .= 'd';
            break;
        default:
            $tipo_params_insert .= 's';
            break;
    }
      $qtde_params_insert .= '?,';
    $params_insert .= '$this->'.$campo["CAMPO"].',
              ';
  }
}
$qtde_params_altera = substr($qtde_params_altera, 0, -1);
$qtde_params_insert = substr($qtde_params_insert, 0, -1);
$params_altera = substr($params_altera, 0, -17);
$params_insert = substr($params_insert, 0, -17);

$php .= 
'    if ('.$if_params_salva.') {
      $com = $c->prepare("CALL '.$nome_tabela.'_altera('.$qtde_params_altera.')");
      $com->bind_param(
              "'.$tipo_params_altera.'",
              '.$params_altera.'
      );
      $com->execute();
    } else {
      $com = $c->prepare("CALL '.$nome_tabela.'_insere('.$qtde_params_insert.')");
      $com->bind_param(
              "'.$tipo_params_insert.'", 
              '.$params_insert.'
      );
      $com->execute();
      $r = $com->get_result();
      $l = $r->fetch_assoc();
      
      '.$chave_primaria.'
      $c->next_result();
    }
  }

  public static function seleciona($ativo = NULL) {
    $c = My::con();
    
    if($ativo == "" || !isset($ativo) || is_null($ativo)){
      $ativo = "S";
    }
    $r = $c->query("CALL '.$tabela['tabela'].'_seleciona(\'$ativo\',EMPRESA)");
    $retorno = [];
    while ($l = $r->fetch_assoc()) {
      $retorno[] = $l;
    }
    $c->next_result();
    return $retorno;
  }
}
?>';

$dir = RAIZ . 'modelo/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new \Exception('Falha ao criar diretório do arquivo' . basename($dir) . '!!');
    }
} 

//---------->> php
$dir = RAIZ . 'modelo/' . $modelo . '.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $php);
if ($fw != strlen($php)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}
