<?php

namespace gerador;

use bd\My;
use bd\Formatos;
use Sistema;

Sistema::ini();

class Gerador {

    const TIPOS = [
        'tinyint' => 'inteiro',
        'smallint' => 'inteiro',
        'int' => 'inteiro',
        'mediumint' => 'inteiro',
        'bigint' => 'inteiro',
        'char' => 'texto',
        'varchar' => 'texto',
        'double' => 'real',
        'decimal' => 'real',
        'float' => 'real',
        'numeric' => 'real',
        'real' => 'real',
        'date' => 'data',
        'datetime' => 'datahora',
        'time' => 'hora',
        'timestamp' => 'hora',
        'tinytext' => 'memo',
        'text' => 'memo',
    ];

    private $tabelas;

    public function __construct() {
        $sistema = Sistema::$nome;
        $c = My::con();
        $r = $c->query("SELECT TABLE_NAME, TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$sistema'");
        while ($l = $r->fetch_assoc()) {
            $dir = RAIZ . 'app/cadastros/' . $l['TABLE_NAME'] . '/index.php';
            $exist = false;
            if (file_exists($dir)) {
                $exist = true;
            }
            $arrComment = explode('*', $l['TABLE_COMMENT']);
            $tabelas [] = [
                'TABLE_NAME' => $l['TABLE_NAME'],
                'TABLE_COMMENT' => (count($arrComment) > 1)? $arrComment[0] : '',
                'EXIST' => $exist
            ];
        }
        $this->tabelas = $tabelas;
    }
    
    public function getTabelas() {
        return $this->tabelas;
    }

    public function setTabelas($tabelas) {
        $this->tabelas = $tabelas;
    }

    public static function construtor($tabela = null) {
        if ($tabela) {
            $ret = self::listaCampos($tabela);
            if ($ret) {
                foreach ($ret as $campo) {
                    $arrNome = explode('_', $campo['COLUMN_NAME']);
                    $descricao_campo = $campo['COLUMN_NAME'];
                    $relaciona_tabela = '';
                    $relaciona_valor = '';
                    $relaciona_descricao = '';
                    $relaciona_filtro = '';
                    $combo = '';
                    $combo_descricao = '';
                    $combo_valor = '';
                    $oculto = false;
                    $tipo = self::retornaTipo($arrNome[0]);

                    if ($campo['COLUMN_COMMENT']) {
                        $arrCommentTotal = explode('*', $campo['COLUMN_COMMENT']);
                        foreach ($arrCommentTotal as $arrComTot) {
                            $arrComment = explode('?', $arrComTot);
                            if ($arrComment[0] == 'relaciona') {
                                $arrRelaciona = explode(':', $arrComment[1]);
                                $relaciona_tabela = $arrRelaciona[0];
                                $desc_valor = explode(';', $arrRelaciona[1]);
                                $relaciona_valor = $desc_valor[0];
                                $desc_filtro = explode('#', $desc_valor[1]);
                                if (count($desc_filtro) == 1) {
                                    $relaciona_descricao = $desc_valor[1];
                                } else {
                                    $relaciona_descricao = $desc_filtro[0];
                                    $relaciona_filtro = $desc_filtro[1];
                                }
                            } else if ($arrComment[0] == 'combo') {
                                $desc_is_value = false;
                                if (substr($arrComment[1], 0, 1) == '=') {
                                    $desc_is_value = true;
                                    $arrComment[1] = substr($arrComment[1], 1);
                                }
                                $arrCombo = explode(';', $arrComment[1]);
                                foreach ($arrCombo as $arr) {
                                    $a_arr = explode(':', $arr);
                                    $descricao = $a_arr[0];
                                    $valor = strtoupper(substr($a_arr[0], 0, $campo['CHARACTER_MAXIMUM_LENGTH']));
                                    //              d($a_arr);
                                    if (count($a_arr) > 1) {
                                        $descricao = $a_arr[1];
                                        $valor = strtoupper($a_arr[0]);
                                    }
                                    $combo[] = [
                                        'DESC_IS_VALUE' => $desc_is_value,
                                        'DESCRICAO' => $descricao,
                                        'VALOR' => $valor,
                                    ];
                                    //              d($valor);
                                }//exit;
                            } else if ($arrComment[0] == 'descricao') {
                                $descricao_campo = $arrComment[1];
                            } else if ($arrComment[0] == 'tipo') {
                                $tipo = self::retornaTipo($arrComment[1]);
                            } else if ($arrComment[0] == 'oculto') {
                                $oculto = true;
                            }
                        }
                    }

                    $campos[] = [
                        'TABELA' => $campo['TABLE_NAME'],
                        'CAMPO' => $campo['COLUMN_NAME'],
                        'DESCRICAO' => $descricao_campo,
//                'VALOR' => ($dados) ? $dados[$campo['COLUMN_NAME']] : '',
                        'OBRIGATORIO' => ($campo['IS_NULLABLE'] == 'NO') ? 'S' : 'N',
                        'TIPO' => ($tipo) ? $tipo : self::TIPOS[$campo['DATA_TYPE']],
                        'COLUMN_TYPE' => $campo['COLUMN_TYPE'],
                        'TAMANHO_TEXTO' => $campo['CHARACTER_MAXIMUM_LENGTH'],
                        'TAMANHO_NUM' => $campo['NUMERIC_PRECISION'],
                        'CASA_DECIMAL' => $campo['NUMERIC_SCALE'],
                        'CHAVE' => $campo['COLUMN_KEY'],
                        'AUTO_INCREMENTO' => ($campo['EXTRA']) ? 'S' : 'N',
                        'COMENTARIO' => $campo['COLUMN_COMMENT'],
                        'RELACIONA_TABELA' => $relaciona_tabela,
                        'RELACIONA_VALOR' => $relaciona_valor,
                        'RELACIONA_DESCRICAO' => $relaciona_descricao,
                        'RELACIONA_FILTRO' => $relaciona_filtro,
                        'COMBO' => $combo,
                        'OCULTO' => ($oculto) ? 'S' : 'N',
                    ];
                }
                return $campos;
            }
        }
    }

//    public static function listaTabelas($menu = null, $tabela = null) {
//        $c = My::con();
//        if ($tabela) {
//            $r = $c->query("SELECT * FROM tabelas_auto WHERE tabela = '$tabela'");
//            $l = $r->fetch_assoc();
//            return $l;
//        } else {
//            $filtro = '';
//            if ($menu) {
//                $filtro = "WHERE menu = '" . $menu . "'";
//            }
//            $r = $c->query("SELECT * FROM tabelas_auto $filtro ORDER BY descricao");
//            while ($l = $r->fetch_assoc()) {
//                $tabelas[] = $l;
//            }
//            return $tabelas;
//        }
//    }

    public static function listaCampos($tabela) {
        $c = My::con();
        $sistema = Sistema::$nome;
        $query = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$sistema' AND TABLE_NAME = '$tabela'";
        $r = $c->query($query);
        $campos = [];
        while ($l = $r->fetch_assoc()) {
            $campos[] = $l;
        }
        return $campos;
    }

    public static function listar($tabela, $valor = NULL, $tabs_relaciona = NULL, $tabs_combo = NULL) {
        $c = My::con();
        $campos = 't1.*';
        $inner = '';
        $i = 2;
        if ($tabs_relaciona) {
            $tabs_relaciona = json_decode($tabs_relaciona);
            foreach ($tabs_relaciona as $tab_relaciona) {
                $array = explode(':', $tab_relaciona->TAB_REL);
                $arrCampos = explode(';', $array[1]);

                $campos .= ',t' . $i . '.' . $arrCampos[2] . ' ' . $arrCampos[0] . '_descricao';
                $inner .= 'LEFT JOIN ' . $array[0] . ' t' . $i . ' ON t1.' . $arrCampos[0] . ' = t' . $i . '.' . $arrCampos[1] . ' ';
                $i++;
            }
        }
        $campos_combo = '';
        if ($tabs_combo) {
            $tabs_combo = json_decode($tabs_combo);
            foreach ($tabs_combo as $tab_combo) {
                foreach ($tab_combo as $key => $value) {
                    $campos_combo .= ", CASE t1." . $key;
                    foreach ($value as $v) {
                        $arrValue = explode(';', $v);
                        $campos_combo .= " WHEN '" . $arrValue[0] . "' THEN '" . ucwords($arrValue[1]) . "'";
                    }
                    $campos_combo .= " ELSE '' END " . $key . "_descricao";
                }
            }
        }

        if ($valor == '' || !isset($valor) || is_null($valor)) {
            $sql = <<< SQL
                SELECT $campos$campos_combo FROM $tabela t1 $inner
SQL;
        } else {
            $sql = <<< SQL
                SELECT $campos$campos_combo FROM $tabela t1 $inner WHERE MATCH(t1.full_text) AGAINST(CONCAT('\'', $valor, '*', '\'') IN BOOLEAN MODE);
SQL;
        }
//        dd($sql);
        $r = $c->query($sql);
        $ret = [];
        while ($l = $r->fetch_assoc()) {
            $ret[] = $l;
        }
        return $ret;
    }

    public static function seleciona($tabela, $array) {
        $c = My::con();
        $filtro = '';
        foreach ($array as $key => $value) {
            $filtro .= "AND " . $key . " = '" . $value . "' ";
        }
        $filtro = substr($filtro, 4);

        $sql = <<< SQL
                SELECT * FROM $tabela WHERE $filtro;
SQL;
        $r = $c->query($sql);
        $l = $r->fetch_assoc();
        return $l;
    }

    public static function selecionaTabelaRelacionada($tabela, $filtro = NULL) {
        $c = My::con();
        if ($filtro) {
            $filtro = 'WHERE ' . $filtro;
        }
        $sql = <<< SQL
                SELECT * FROM $tabela $filtro;
SQL;
        $r = $c->query($sql);
        $ret = [];
        while ($l = $r->fetch_assoc()) {
            $ret[] = $l;
        }
        return $ret;
    }

    public static function salva($array) {
        $c = My::con();
        $usuario = unserialize($_SESSION['usuario']);
        $data_atual = date('Y-m-d H:i');
        $filtro = '';
        $campo_valor = '';
        $campo = '';
        $valor = '';
        $update = true;

        foreach ($array as $value) {
            $tabela = $value['TABELA'];
            $is_num = ($value['TIPO'] == 'inteiro' || $value['TIPO'] == 'real' || $value['TIPO'] == 'moeda') ? true : false;
            if ($value['CHAVE'] == 'PRI' && $value['VALOR'] != '') {// entra campo chave primaria com valor preenchido
                $sql = "SELECT " . $value['CAMPO'] . " FROM $tabela WHERE " . $value['CAMPO'] . " = '" . TabelasAuto::valorFormatadoBD($value['TIPO'], $value['VALOR']) . "' ";
                $r = $c->query($sql);
                $ret = $r->fetch_assoc();

                if ($ret) {//verifica se existe o registro pra dar update
                    $filtro .= "AND " . $value['CAMPO'] . " = '" . TabelasAuto::valorFormatadoBD($value['TIPO'], $value['VALOR']) . "' ";
                } else {
                    $update = false;
                }
            } else if ($value['CHAVE'] == 'PRI' && $value['VALOR'] == '') {//entra campo chave primaria com valor em branco, registro novo
                $update = false;
            }
            $pos_usuario = self::campoUsuario($value['CAMPO']);
            $empresa = self::campoEmpresa($value['CAMPO']);
            if ($value['CHAVE'] != 'PRI') {// entra campo que n??o s??o chaves primarias
                $value['VALOR'] = ($value['VALOR']) ? TabelasAuto::valorFormatadoBD($value['TIPO'], $value['VALOR']) : ((!$is_num) ? '' : '0' );
                if ($pos_usuario && $value['OCULTO'] == 'S') {// entra se for campo de usuario oculto, para salvar o usuario que fez a operacao (insert)
                    $value['VALOR'] = $usuario->getCodigo();
                }
                if ($empresa != '' && $value['OCULTO'] == 'S') {// entra se for campo de empresa oculto, para salvar a empresa que fez a operacao
                    $value['VALOR'] = $empresa;
                }
                if ($value['TIPO'] == 'datahora' && $value['OCULTO'] == 'S') {// entra se for campo de data oculto, para salvar o data atual que foi feita a operacao
                    $value['VALOR'] = $data_atual;
                }
                if ($update) {
                    $pos1 = stripos($value['CAMPO'], 'insert');
                    $pos2 = stripos($value['CAMPO'], 'created');
                    if ($pos1 === false && $pos2 === false) {
                        $campo_valor .= $value['CAMPO'] . " = '" . $value['VALOR'] . "',";
                    }
                }
            }
            if ($value['AUTO_INCREMENTO'] != 'S') {// entra campo que n??o s??o autoincremento
                $campo .= $value['CAMPO'] . ',';
                $value['VALOR'] = ($value['VALOR']) ? TabelasAuto::valorFormatadoBD($value['TIPO'], $value['VALOR']) : ((!$is_num) ? '' : '0' );
                if ($pos_usuario && $value['OCULTO'] == 'S') {// entra se for campo de usuario oculto, para salvar o usuario que fez a operacao (insert)
                    $value['VALOR'] = $usuario->getCodigo();
                }
                if ($empresa != '' && $value['OCULTO'] == 'S') {// entra se for campo de empresa oculto, para salvar a empresa que fez a operacao
                    $value['VALOR'] = $empresa;
                }
                if ($value['TIPO'] == 'datahora' && $value['OCULTO'] == 'S') {// entra se for campo de data oculto, para salvar o data atual que foi feita a operacao
                    $value['VALOR'] = $data_atual;
                }
                $valor .= "'" . $value['VALOR'] . "',";
            }
        }

        if ($update) {
            $filtro = substr($filtro, 4);
            $campo_valor = substr($campo_valor, 0, -1);
            $sql = <<< SQL
                UPDATE $tabela SET $campo_valor WHERE $filtro;
SQL;
            $r = $c->query($sql);
        } else {
            $campo = substr($campo, 0, -1);
            $valor = substr($valor, 0, -1);

            $sql = <<< SQL
                INSERT INTO $tabela ($campo) VALUES ($valor);
SQL;
            $r = $c->query($sql);
        }
    }

//  public static function exclui($tabela, $array) {
//    $c = My::con();
//    $filtro = '';
//    foreach ($array as $key => $value) {
//      $filtro .= "AND " . $key . " = '" . $value . "' ";
//    }
//    $filtro = substr($filtro, 4);
//
//    $sql = <<< SQL
//                DELETE FROM $tabela WHERE $filtro;
//SQL;
//    $r = $c->query($sql);
////    $l = $r->fetch_assoc();
////    return $l;
//  }

    public static function TipoFormato($tipo, $flag) {
        $valor = '';
        switch ($tipo) {
            case 'cep':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::cepBd(';
                } else {
                    $valor = '\bd\Formatos::cepApp(';
                }
                break;
            case 'cnpj':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::cnpjBd(';
                } else {
                    $valor = '\bd\Formatos::cnpjApp(';
                }
                break;
            case 'cpf':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::cpfBd(';
                } else {
                    $valor = '\bd\Formatos::cpfApp(';
                }
                break;
            case 'data':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::dataBd(';
                } else {
                    $valor = '\bd\Formatos::dataApp(';
                }
                break;
            case 'datahora':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::dataHoraBd(';
                } else {
                    $valor = '\bd\Formatos::dataHoraApp(';
                }
                break;
            case 'email':
                $valor = '\bd\Formatos::email(';
                break;
            case 'ft':
                $valor = '\bd\Formatos::ft(';
                break;
            case 'inteiro':
                $valor = '\bd\Formatos::inteiro(';
                break;
            case 'moeda':
                if ($flag == 'bd') {
                    $valor = "str_replace(',', '.', ";
                } else {
                    $valor = '\bd\Formatos::moeda(';
                }
                break;
            case 'nome':
                $valor = '\bd\Formatos::nome(';
                break;
            case 'real':
                $valor = '\bd\Formatos::real(';
                break;
            case 'telefone':
                if ($flag == 'bd') {
                    $valor = '\bd\Formatos::telefoneBd(';
                } else {
                    $valor = '\bd\Formatos::telefoneApp(';
                }
                break;
        }
        return $valor;
    }

    public static function valorFormatadoBD($tipo, $valor) {
        switch ($tipo) {
            case 'cep':
                $valor = Formatos::cepBd($valor);
                break;
            case 'cnpj':
                $valor = Formatos::cnpjBd($valor);
                break;
            case 'cpf':
                $valor = Formatos::cpfBd($valor);
                break;
            case 'data':
                $valor = Formatos::dataBd($valor);
                break;
            case 'datahora':
                $valor = Formatos::dataHoraBd($valor);
                break;
            case 'email':
                $valor = Formatos::email($valor);
                break;
            case 'ft':
                $valor = Formatos::ft($valor);
                break;
            case 'inteiro':
                $valor = Formatos::inteiro($valor);
                break;
            case 'moeda':
                $valor = str_replace(',', '.', $valor);
                break;
            case 'nome':
                $valor = Formatos::nome($valor);
                break;
            case 'real':
                $valor = Formatos::real($valor);
                break;
            case 'telefone':
                $valor = Formatos::telefoneBd($valor);
                break;
        }
        return $valor;
    }

    public static function valorFormatadoApp($tipo, $valor) {
        switch ($tipo) {
            case 'cep':
                $valor = Formatos::cepApp($valor);
                break;
            case 'cnpj':
                $valor = Formatos::cnpjApp($valor);
                break;
            case 'cpf':
                $valor = Formatos::cpfApp($valor);
                break;
            case 'data':
                $valor = Formatos::dataApp($valor);
                break;
            case 'datahora':
                $valor = Formatos::dataHoraApp($valor);
                break;
            case 'email':
                $valor = Formatos::email($valor);
                break;
            case 'ft':
                $valor = Formatos::ft($valor);
                break;
            case 'inteiro':
                $valor = Formatos::inteiro($valor);
                break;
            case 'moeda':
                $valor = Formatos::moeda($valor);
                break;
            case 'nome':
                $valor = Formatos::nome($valor);
                break;
            case 'real':
                $valor = Formatos::real($valor);
                break;
            case 'telefone':
                $valor = Formatos::telefoneApp($valor);
                break;
        }
        return $valor;
    }

    private static function retornaTipo($tp) {
        $tipo = '';
        switch ($tp) {
            case 'email':
                $tipo = 'email';
                break;
            case 'mail':
                $tipo = 'email';
                break;
            case 'e-mail':
                $tipo = 'email';
                break;
            case 'cep':
                $tipo = 'cep';
                break;
            case 'telefone':
                $tipo = 'telefone';
                break;
            case 'tel':
                $tipo = 'telefone';
                break;
            case 'cel':
                $tipo = 'telefone';
                break;
            case 'celular':
                $tipo = 'telefone';
                break;
            case 'cpf':
                $tipo = 'cpf';
                break;
            case 'cnpj':
                $tipo = 'cnpj';
                break;
        }

        return $tipo;
    }

    public static function campoUsuario($valor) {
        $ret = false;
        
        if (stripos($valor, 'usuario') !== false 
            || stripos($valor, 'user') !== false
            || stripos($valor, 'login') !== false) {
            $ret =  true;
        }
        return $ret;
    }

    public static function campoEmpresa($valor) {
        $ret = '';
        if (stripos($valor, 'church') !== false 
            || stripos($valor, 'empresa') !== false
            || stripos($valor, 'conta') !== false) {
            $ret =  EMPRESA;
        }
        return $ret;
    }
    
    public static function listaKeys($tabela) {
        $sistema = Sistema::$nome;
        $c = My::con();
        $r = $c->query("  SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '$sistema' AND TABLE_NAME = '$tabela' AND REFERENCED_TABLE_NAME IS NOT NULL;");
        $campos = [];
        while ($l = $r->fetch_assoc()) {
            $campos [] = [
                'TABLE_NAME' => $l['TABLE_NAME'],
                'COLUMN_NAME' => $l['COLUMN_NAME']
            ];
        }
        return $campos;
    }
}

/*
  SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clinica' AND TABLE_NAME = 'funcao';

  SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'mpasquarelli' AND TABLE_NAME = 'funcao';

  SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'clinica' AND TABLE_NAME = 'agenda_itens' AND REFERENCED_TABLE_NAME IS NOT NULL;
 */
