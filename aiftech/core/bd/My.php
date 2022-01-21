<?php

namespace bd;

class My
{
    public static $dataSourcePadrao;
    private static $conexoes = [];

    /**
     *
     * @param string $dataSource
     * @return \mysqli
     * @throws \Exception
     */
    public static function con($dataSource = null)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $confs = conf('mysql');
        $conf = $confs[SERVIDOR];
        if ($conf) {
            if (!$dataSource) {
                $dataSource = self::$dataSourcePadrao ?: array_keys($conf)[0];
            }
            if (!isset(self::$conexoes[$dataSource])) {
                if (isset($conf[$dataSource])) {
                    $conf = $conf[$dataSource];
                    $mysqli = \mysqli_init();
                    $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
                    $mysqli->real_connect($conf['servidor'], $conf['usuario'], $conf['senha'], $conf['banco']);
                    $mysqli->set_charset('utf8');
                    self::$conexoes[$dataSource] = $mysqli;
                } else {
                    throw new \Exception('Conexão MySQL de nome "' . $dataSource . '" não configurada.');
                }
            }
            return self::$conexoes[$dataSource];
        } else {
            throw new \Exception('Não há nenhuma configuração de banco de dados MySQL.');
        }
    }

    public static function deleteAll(\mysqli $conexao, $tabela)
    {
        $sql = 'DELETE FROM ' . $tabela . '; ALTER TABLE ' . $tabela . ' AUTO_INCREMENT=1';
        $conexao->multi_query($sql);
        $conexao->next_result();
    }

    /**
     * @param \mysqli $c
     * @param $nomeProcedure
     * @param $parametros
     * @return \mysqli_result|\mysqli_result[]
     */
    public static function call(\mysqli $c, $nomeProcedure, $parametros)
    {
        $sql = 'CALL ' . $nomeProcedure . '(' . implode(',', My::escape($c, $parametros)) . ')';
        $c->multi_query($sql);
        $ret = [];
        do {
            if ($r = $c->store_result()) {
                $ret[] = $r;
            }
        } while ($c->more_results() && $c->next_result());
        if (count($ret) == 1) {
            return $ret[0];
        }
        return $ret;
    }

    public static function escape(\mysqli $c, $dado)
    {
        if (is_array($dado)) {
            $ret = [];
            foreach ($dado as $d) {
                $ret[] = self::escape($c, $d);
            }
            return $ret;
        }
        if ($dado === null) {
            return 'NULL';
        }
        if (is_string($dado)) {
            return '\'' . $c->real_escape_string($dado) . '\'';
        }
        if (is_bool($dado)) {
            return $dado ? 1 : 0;
        }
        return $dado;
    }
}