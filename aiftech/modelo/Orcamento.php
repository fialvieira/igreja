<?php

namespace modelo;

use bd\My;

class Orcamento
{

    private $id;
    private $ano;
    private $mes;
    private $categoria_id;
    private $categoria_nome;
    private $valor_previsto;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Orcamento constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL orcamento_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $l["id"];
                $this->ano = $l["ano"];
                $this->mes = $l["mes"];
                $this->categoria_id = $l["categoria_id"];
                $this->categoria_nome = $l["categoria_nome"];
                $this->valor_previsto = $l["valor_previsto"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return \bd\Formatos::inteiro($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @return mixed
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param mixed $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * @return mixed
     */
    public function getCategoriaId()
    {
        return $this->categoria_id;
    }

    /**
     * @param mixed $categoria_id
     */
    public function setCategoriaId($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    /**
     * @return mixed
     */
    public function getCategoriaNome()
    {
        return $this->categoria_nome;
    }

    /**
     * @return mixed
     */
    public function getValorPrevisto()
    {
        return \bd\Formatos::moeda($this->valor_previsto);
    }

    /**
     * @param mixed $valor_previsto
     */
    public function setValorPrevisto($valor_previsto)
    {
        $this->valor_previsto = \bd\Formatos::real($valor_previsto);
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return \bd\Formatos::inteiro($this->empresa_id);
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return \bd\Formatos::inteiro($this->user_id);
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = \bd\Formatos::inteiro($user_id);
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->ano) {
            throw new \Exception("Ano obrigatório.");
        }

        if (!$this->mes) {
            throw new \Exception("Mês obrigatório.");
        }

        if (!$this->categoria_id) {
            throw new \Exception("Conta obrigatória.");
        }

        if (!$this->valor_previsto) {
            throw new \Exception("Valor Previsto obrigatório.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL orcamento_altera(?,?,?,?,?)");
            $com->bind_param(
                "idiis", $this->id, $this->valor_previsto, $this->empresa_id, $this->user_id, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL orcamento_insere(?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssidiis", $this->ano, $this->mes, $this->categoria_id, $this->valor_previsto, $this->empresa_id,
                $this->user_id, $this->created
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->id = $l["id"];
            $c->next_result();
        }
    }

    public static function seleciona($ano = null, $mes = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if (is_null($ano) || !isset($ano) || $ano == '') {
            $ano = null;
        }
        if (is_null($mes) || !isset($mes) || $mes == '') {
            $mes = null;
        }
        $com = $c->prepare("CALL orcamento_seleciona_todos(?,?,?)");
        $com->bind_param(
            "iss", $empresa, $ano, $mes
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function getAnosAtivos()
    {
        $ano_inicio = '2017';
        $ano_fim = date('Y', strtotime('+1 year'));
        $anos = [];
        while ($ano_inicio <= $ano_fim) {
            $anos [] = [
                'ano' => $ano_fim
            ];
            $ano_fim--;
        }

        return $anos;
    }

    public static function listaOrcamentos($ano = null, $mes = null, $cat = null)
    {
        $c = My::con();

        $empresa = EMPRESA;
        $com = $c->prepare("SELECT T1.*
                            FROM orcamento T1
                            WHERE T1.empresa_id = ?
                              AND (IFNULL(T1.ano,'') > IFNULL(?,IFNULL(T1.ano,'')) 
                                   OR (IFNULL(T1.ano,'') = IFNULL(?,IFNULL(T1.ano,''))  
                                       AND IFNULL(T1.mes,'') >= IFNULL(?,IFNULL(T1.mes,''))
                                      )
                                  )
                             -- AND IFNULL(T1.ano,'') >= IFNULL(?,IFNULL(T1.ano,''))
                             -- AND IFNULL(T1.mes,'') >= IFNULL(?,IFNULL(T1.mes,''))
                              AND IFNULL(T1.categoria_id,'') = IFNULL(?,IFNULL(T1.categoria_id,''))
                            ORDER BY T1.ano, CAST(T1.mes AS UNSIGNED)");
        $com->bind_param(
            "isssi", $empresa, $ano, $ano, $mes, $cat
        );

        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }

        return $retorno;
    }

    public static function listaAcompanhamentoOrcamento($ano, $mes = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($mes) || !isset($mes) || $mes == '') {
                $mes = null;
            }
            $com = $c->prepare('CALL rel_acompanhamento_orcamento(?,?,?)');
            $com->bind_param(
                "iss", $empresa, $ano, $mes
            );
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

    public static function relatorio_acompanhamento($ano, $mes = null)
    {
        $c = My::con();
        $empresa = EMPRESA;

        if (is_null($mes) || !isset($mes) || $mes == '') {
            $mes = null;
        }

        $com = $c->prepare('CALL rel_acompanhamento_orcamento(?,?,?)');
        $com->bind_param(
            "iss", $empresa, $ano, $mes
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $l['chave'] = $l['id'] . '-' . $l['ano'] . '-' . $l['mes'];
            $retorno[] = $l;

            if ($l['flag_mae'] == 'S' && !is_null($l['mae'])) {
                $tem_mae = true;
                $mae = $l['mae'];
                while ($tem_mae) {
                    if ($mae != '' || !is_null($mae)) {
                        $chave = $l['mae'] . '-' . $l['ano'] . '-' . $l['mes'];
                        $key = array_search($chave, array_column($retorno, 'chave'));
                        if ($key !== false) {
                            $retorno[$key]['valor_previsto'] += $l['valor_previsto'];
                            $retorno[$key]['valor_realizado'] += $l['valor_realizado'];
                            $mae = $retorno[$key]['mae']; //-> aponta para a proxima mae
                        }
                    } else {
                        $tem_mae = false; //--> acabou as mae, sai do while.
                    }
                }
            }
        }
        return $retorno;
    }

}
