<?php
/**
 * Created by PhpStorm.
 * User: 81102569
 * Date: 26/01/2018
 * Time: 09:20
 */

namespace modelo;

use bd\Formatos;
use bd\My;

class RelatoriosMembros
{
    private $empresa_id;

    public function __construct()
    {
        $this->empresa_id = EMPRESA;
    }

    public function membrosTotalGeral($status = null)
    {
        $c = My::con();
        $com = $c->prepare("SELECT	COUNT(*) TOTAL_GERAL
                                  FROM membros m
                                  INNER JOIN membros_frequencia mf
                                      ON m.frequencia_id = mf.id
                                     AND m.empresa_id = mf.empresa_id
                                  WHERE m.empresa_id = ?
                                    AND mf.status = IFNULL(?, mf.status)");
        $com->bind_param("is", $this->empresa_id, $status);
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();
        return Formatos::inteiro($l['TOTAL_GERAL']);
    }

    public function quorumSede()
    {
        $c = My::con();
        $com = $c->prepare("SELECT  mf.frequencia,
                                          COUNT(*) TOTAL
                                  FROM membros m
                                  INNER JOIN membros_frequencia mf
                                      ON m.frequencia_id = mf.id
                                     AND m.empresa_id = mf.empresa_id
                                  INNER JOIN local l
                                    ON m.local_id = l.id
                                   AND m.empresa_id = l.empresa_id
                                  WHERE mf.status = 'A'
                                    AND mf.quorum = 'S'
                                    AND (l.e_sede = 'S' OR l.`sede` = 'S')
                                    AND l.ativo = 'S'
                                    AND m.empresa_id = ?
                                  GROUP BY mf.frequencia");
        $com->bind_param("i", $this->empresa_id);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public function naoQuorumSede()
    {
        $c = My::con();
        $com = $c->prepare("SELECT  mf.frequencia,
                                        COUNT(*) TOTAL
                                  FROM membros m
                                  INNER JOIN membros_frequencia mf
                                    ON m.frequencia_id = mf.id
                                   AND m.empresa_id = mf.empresa_id
                                  INNER JOIN local l
                                    ON m.local_id = l.id
                                   AND m.empresa_id = l.empresa_id
                                  WHERE mf.status = 'A'
                                    AND mf.quorum <> 'S'
                                    AND l.e_sede = 'S'
                                    AND l.ativo = 'S'
                                    AND m.empresa_id = ?
                                  GROUP BY mf.frequencia");
        $com->bind_param("i", $this->empresa_id);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public function quorumForaDaSedeTotal($local_id = null)
    {
        try {
            $c = My::con();
            $com = $c->prepare("SELECT l.nome,
                                              l.id,
                                              mf.`quorum`,
                                              COUNT(mf.frequencia) TOTAL
                                      FROM membros m
                                      INNER JOIN membros_frequencia mf
                                         ON m.frequencia_id = mf.id
                                        AND m.empresa_id = mf.empresa_id
                                      INNER JOIN `local` l
                                         ON m.local_id = l.id
                                        AND m.empresa_id = l.empresa_id
                                      WHERE l.e_sede = 'N'
                                        AND l.`sede` = 'N'
                                        AND l.`ativo` = 'S'
                                        AND mf.status = 'A'
                                        AND m.empresa_id = ?
                                        AND l.id = IFNULL(?, l.id)
                                      GROUP BY l.nome, l.id, mf.`quorum`
                                      ORDER BY l.nome, l.id, mf.`quorum` DESC");
            $com->bind_param("ii", $this->empresa_id, $local_id);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function quorumNaoSedeDetalhado($local_id = null, $quorum = null)
    {
        try {
            $c = My::con();
            $com = $c->prepare("SELECT mf.frequencia,
	                                          COUNT(mf.frequencia) TOTAL
                                      FROM membros m
                                      INNER JOIN membros_frequencia mf
                                        ON m.frequencia_id = mf.id
                                       AND m.empresa_id = mf.empresa_id
                                      INNER JOIN local l
                                        ON m.local_id = l.id
                                       AND m.empresa_id = l.empresa_id
                                      WHERE l.e_sede = 'N'
                                        AND l.sede = 'N'
                                        AND l.ativo = 'S'
                                        AND mf.quorum = ?
                                        AND mf.status = 'A'
                                        AND m.empresa_id = ?
                                        AND l.id = IFNULL(?, l.id)
                                      GROUP BY  mf.frequencia");
            $com->bind_param("sii", $quorum,$this->empresa_id, $local_id);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function aniversariantes($mes)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("CALL relatorio_aniversariantes_sel(?, ?)");
        $com->bind_param("ii", $empresa, $mes);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function bodas($mes)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if (!is_null($mes)) {
            $com = $c->prepare("SELECT tbl.nome1
                                         ,tbl.nome2
                                         ,tbl.data_casamento
                                         ,tbl.tempo
                                         ,tbl.bodas
                                    FROM
                                        (SELECT CASE
                                                  WHEN m1.sexo = 'F' THEN SUBSTRING(m1.`nome`, 1, LOCATE(' ', m1.`nome`))
                                                  WHEN m2.sexo = 'F' THEN SUBSTRING(m2.`nome`, 1, LOCATE(' ', m2.`nome`))
                                                END nome1
                                                ,CASE
                                                   WHEN m2.sexo = 'M' THEN m2.`nome`
                                                   WHEN m1.sexo = 'M' THEN m1.`nome`
                                                 END nome2
                                                ,CONCAT(LPAD(DAY(m1.`data_casamento`), 2, '0'), '/', LPAD(MONTH(m1.`data_casamento`), 2, '0')) data_casamento
                                                ,CASE
                                                   WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'M'), ' meses')
                                                   WHEN fn_diff_date(m1.`data_casamento`, 'M') = 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'A'), ' ano')
                                                   ELSE CONCAT(YEAR(CURDATE()) - YEAR(m1.data_casamento), ' anos')
                                                 END tempo
                                                ,(SELECT nome
                                                    FROM bodas
                                                    WHERE tempo = CASE
                                                                    WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN fn_diff_date(m1.`data_casamento`, 'M')
                                                                    ELSE (fn_diff_date(m1.`data_casamento`, 'A') * 12)
                                                                  END) bodas
                                        FROM relacionamentos r
                                        LEFT JOIN membros m1
                                          ON r.`membro_id` = m1.`id`
                                        INNER JOIN membros_frequencia mf1
                                          ON m1.`frequencia_id` = mf1.`id`
                                        LEFT JOIN membros m2
                                          ON r.`membro2_id` = m2.`id`
                                        INNER JOIN membros_frequencia mf2
                                          ON m2.`frequencia_id` = mf2.`id`
                                        WHERE r.`empresa_id` = ?
                                          AND MONTH(m1.`data_casamento`) = ?
                                          AND r.tiporelacionamento_id = 3
                                          AND (mf1.`status` = 'A' AND mf2.`status` = 'A')
                                          AND m2.id IS NOT NULL
                                        ORDER BY DAY(m1.`data_casamento`)) tbl
                                    GROUP BY tbl.data_casamento, tbl.tempo, tbl.nome1, tbl.nome2, tbl.bodas
                                    ORDER BY MAX(tbl.data_casamento)");
            $com->bind_param("is", $empresa, $mes);
        } else {
            $com = $c->prepare("SELECT IFNULL(tbl.nome1, '') nome1
                                              ,IFNULL(tbl.nome2, '') nome2
                                              ,tbl.data_casamento
                                              ,tbl.tempo
                                              ,tbl.bodas
                                              ,tbl.casamento
                                              ,tbl.mes
                                              ,tbl.ano
                                              ,tbl.dia
                                        FROM
                                            (SELECT CASE
                                                      WHEN m1.sexo = 'F' THEN SUBSTRING(m1.`nome`, 1, LOCATE(' ', m1.`nome`))
                                                      WHEN m2.sexo = 'F' THEN SUBSTRING(m2.`nome`, 1, LOCATE(' ', m2.`nome`))
                                                    END nome1
                                                    ,CASE
                                                       WHEN m2.sexo = 'M' THEN m2.`nome`
                                                       WHEN m1.sexo = 'M' THEN m1.`nome`
                                                     END nome2
                                                    ,CONCAT(LPAD(DAY(m1.`data_casamento`), 2, '0'), '/', LPAD(MONTH(m1.`data_casamento`), 2, '0')) data_casamento
                                                    ,CASE
                                                       WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'M'), ' meses')
                                                       WHEN fn_diff_date(m1.`data_casamento`, 'M') = 12 THEN CONCAT(fn_diff_date(m1.`data_casamento`, 'A'), ' ano')
                                                       ELSE CONCAT(YEAR(CURDATE()) - YEAR(m1.data_casamento), ' anos')
                                                     END tempo
                                                    ,(SELECT nome
                                                        FROM bodas
                                                        WHERE tempo = CASE
                                                                        WHEN fn_diff_date(m1.`data_casamento`, 'M') < 12 THEN fn_diff_date(m1.`data_casamento`, 'M')
                                                                        ELSE (fn_diff_date(m1.`data_casamento`, 'A') * 12)
                                                                      END) bodas
                                                    ,m1.`data_casamento` casamento
                                                    ,MONTH(m1.`data_casamento`) mes
                                                    ,YEAR(m1.`data_casamento`) ano
                                                    ,DAY(m1.`data_casamento`) dia
                                            FROM relacionamentos r
                                            LEFT JOIN membros m1
                                              ON r.`membro_id` = m1.`id`
                                            INNER JOIN membros_frequencia mf1
                                              ON m1.`frequencia_id` = mf1.`id`
                                            LEFT JOIN membros m2
                                              ON r.`membro2_id` = m2.`id`
                                            INNER JOIN membros_frequencia mf2
                                              ON m2.`frequencia_id` = mf2.`id`
                                            WHERE r.`empresa_id` = ?
                                              AND m1.`data_casamento` IS NOT NULL
                                              AND r.tiporelacionamento_id = 3
                                              AND (mf1.`status` = 'A' AND mf2.`status` = 'A')
                                              AND m2.id IS NOT NULL) tbl
                                        GROUP BY tbl.data_casamento, tbl.tempo, tbl.nome1, tbl.nome2, tbl.bodas
                                        ORDER BY tbl.mes, tbl.dia, tbl.ano");
            $com->bind_param("i", $empresa);
        }
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function inconsistencias()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("SELECT   m.id
                                            ,m.nome
                                            ,CASE
                                                    WHEN m.datanascimento = '2016-01-01' THEN 'Data de nascimento não cadastrada'
                                                    ELSE m.datanascimento
                                             END datanascimento
                                            ,CASE
                                                    WHEN m.cpf IS NULL THEN 'CPF não cadastrado'
                                                    WHEN m.cpf = '' THEN 'CPF não cadastrado'
                                                  ELSE cpf
                                             END cpf
                                            ,IFNULL(m.sexo, 'Sexo não cadastrado') sexo
                                            ,IFNULL(m.enderecos_id, 'Endereço não cadastrado') endereco
                                            ,IFNULL(m.email, 'E-mail não cadastrado') email
                                            ,IFNULL(m.fone, 'Telefone não cadastrado') fone
                                            ,IFNULL(m.cel, 'Celular não cadastrado') cel
                                            ,IFNULL(m.frequencia_id, 'Frequência não cadastrado') frequencia
                                FROM membros m
                                LEFT JOIN membros_frequencia mf
                                  ON m.frequencia_id = mf.id
                                 AND m.empresa_id = mf.empresa_id
                                WHERE m.empresa_id = ?
                                  AND mf.status = 'A'
                                  AND (
                                        m.datanascimento = '2016-01-01'
                                          OR (m.cpf IS NULL OR m.cpf = '')
                                          OR LENGTH(m.nome) < 3
                                          OR m.sexo IS NULL
                                          OR m.enderecos_id IS NULL
                                          OR m.email IS NULL
                                          OR m.frequencia_id IS NULL
                                      )
                                ORDER BY m.nome");
        $com->bind_param("i", $empresa);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function membros($ativo, $quorum)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("CALL membros_seleciona_rel(?, ?, ?);");
        $com->bind_param("iss", $empresa, $ativo, $quorum);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function membrosAgendaEnderecos($ativo, $quorum, $flag_endereco)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'CALL membro_agenda_enderecos_sel (?, ?, ?, ?)';
            $com = $c->prepare($query);
            $com->bind_param("isss", $empresa, $ativo, $quorum, $flag_endereco);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function membrosAgenda($ativo, $quorum, $local)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT T1.`nome`,
                             fn_remove_accents(SUBSTRING(T1.`nome`, 1, 1)) letra,
                             T1.`fone`,
                             T1.`cel`,
                             T1.`email`,
                             T2.sigla estado,
                             e.`cep`,
                             e.`logradouro`,
                             T1.`enderecos_numero`,
                             e.`bairro`,
                             e.`localidade` municipio,
                             T1.`enderecos_complemento`,
                             l.`nome` `local`
                    FROM membros T1
                    LEFT JOIN `local` l
                                 ON T1.`local_id` = l.`id`
                                AND T1.`empresa_id` = l.`empresa_id` 
                    LEFT JOIN membros_frequencia mf
                                 ON T1.frequencia_id = mf.id
                    LEFT JOIN enderecos e
                                 ON T1.enderecos_id = e.`id`
                    LEFT JOIN estados T2
                                 ON e.estado_id = T2.id
                    WHERE T1.empresa_id = ?
                        AND mf.status = IFNULL(?, mf.`status`)
                        AND mf.quorum = IFNULL(?, mf.`quorum`)
                        AND T1.`local_id` = IFNULL(?, T1.`local_id`)
                    ORDER BY l.`nome`, T1.`nome`';
            $com = $c->prepare($query);
            $com->bind_param("isss", $empresa, $ativo, $quorum, $local);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}