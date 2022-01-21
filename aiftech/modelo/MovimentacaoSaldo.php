<?php

namespace modelo;

use bd\Formatos;
use bd\My;

class MovimentacaoSaldo {

    private $id;
    private $tipo;
    private $tipo_descricao;
    private $data;
    private $descricao;
    private $saldo;
    private $saldo_origem;
    private $saldo_destino;
    private $conta_financ_id;
    private $contas_financeira_origem_id;
    private $valor;
    private $contas_financeira_destino_id;
    private $cancelado;
    private $user_cancela;
    private $justifica_cancela;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $cf_origem;
    private $banco_origem;
    private $cf_destino;
    private $banco_destino;

    const TIPO_ENTRADA = 'E';
    const TIPO_SAIDA = 'S';
    const TIPOS = [
        'E' => 'Entrata (Crédito)',
        'S' => 'Saída (Débito)'
    ];

    /**
     * CategoriasFinanceira constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $empresa = EMPRESA;
            $c = My::con();
            $r = $c->query("SELECT MS.*
                                        ,CFO.`nome` CF_ORIGEM
                                        ,BO.`nome` BANCO_ORIGEM
                                        ,CFD.`nome` CF_DESTINO
                                        ,BD.`nome` BANCO_DESTINO
                                        ,CASE
                                            WHEN MS.tipo = 'S' THEN 'Débito'
                                            ELSE 'Crédito'
                                         END TIPO_DESCRICAO
                                  FROM movimentacao_saldo MS
                                  INNER JOIN contas_financeira CFO
                                    ON MS.`contas_financ_origem_id` = CFO.`id`
                                   AND MS.`empresa_id` = CFO.`empresa_id`
                                  INNER JOIN bancos BO
                                    ON CFO.`banco_id` = BO.`id`
                                  INNER JOIN contas_financeira CFD
                                    ON MS.`contas_financ_destino_id` = CFD.`id`
                                   AND MS.`empresa_id` = CFD.`empresa_id`
                                  INNER JOIN bancos BD
                                    ON CFD.`banco_id` = BD.`id`
                                  WHERE MS.cancelado = 'N'
                                    AND MS.empresa_id = $empresa
                                    AND MS.id = $id");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->tipo = $l["tipo"];
                $this->data = $l["data"];
                $this->descricao = $l["descricao"];
                $this->tipo_descricao = $l["TIPO_DESCRICAO"];
                $this->conta_financ_id = $l["conta_financ_id"];
                $this->contas_financeira_origem_id = $l["contas_financ_origem_id"];
                $this->contas_financeira_destino_id = $l["contas_financ_destino_id"];
                $this->valor = $l["valor"];
                $this->saldo = $l["saldo"];
                $this->cf_origem = $l["CF_ORIGEM"];
                $this->cf_destino = $l["CF_DESTINO"];
                $this->cancelado = $l["cancelado"];
                $this->user_cancela = $l["user_id_cancela"];
                $this->justifica_cancela = $l["justificativa_cancela"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->banco_origem = $l["BANCO_ORIGEM"];
                $this->banco_destino = $l["BANCO_DESTINO"];
            }
        }
    }

    /**
     * @return mixed
     */
    public function getContaFinancId() {
        return $this->conta_financ_id;
    }

    /**
     * @param mixed $conta_financ_id
     */
    public function setContaFinancId($conta_financ_id) {
        $this->conta_financ_id = $conta_financ_id;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getTipoDescricao() {
        return $this->tipo_descricao;
    }

    /**
     * @param mixed $tipo_descricao
     */
    public function setTipoDescricao($tipo_descricao) {
        $this->tipo_descricao = $tipo_descricao;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = Formatos::dataBd($data);
    }

    /**
     * @return mixed
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getSaldoOrigem() {
        return $this->saldo_origem;
    }

    /**
     * @param mixed $saldo
     */
    public function setSaldoOrigem($saldo) {
        $this->saldo_origem = Formatos::real($saldo);
    }

    /**
     * @return mixed
     */
    public function getSaldoDestino() {
        return $this->saldo_destino;
    }

    /**
     * @param mixed $saldo_destino
     */
    public function setSaldoDestino($saldo_destino) {
        $this->saldo_destino = Formatos::real($saldo_destino);
    }

    public function getSaldo() {
        return $this->saldo;
    }

    /**
     * @return mixed
     */
    public function getContasFinanceiraOrigemId() {
        return $this->contas_financeira_origem_id;
    }

    /**
     * @param mixed $contas_financeira_origem_id
     */
    public function setContasFinanceiraOrigemId($contas_financeira_origem_id) {
        $this->contas_financeira_origem_id = $contas_financeira_origem_id;
    }

    /**
     * @return mixed
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor) {
        $this->valor = Formatos::real($valor);
    }

    /**
     * @return mixed
     */
    public function getContasFinanceiraDestinoId() {
        return $this->contas_financeira_destino_id;
    }

    /**
     * @param mixed $contas_financeira_destino_id
     */
    public function setContasFinanceiraDestinoId($contas_financeira_destino_id) {
        $this->contas_financeira_destino_id = $contas_financeira_destino_id;
    }

    /**
     * @return mixed
     */
    public function getCancelado() {
        return $this->cancelado;
    }

    /**
     * @param mixed $cancelado
     */
    public function setCancelado($cancelado) {
        $this->cancelado = $cancelado;
    }

    /**
     * @return mixed
     */
    public function getUserCancela() {
        return $this->user_cancela;
    }

    /**
     * @param mixed $user_cancela
     */
    public function setUserCancela($user_cancela) {
        $this->user_cancela = $user_cancela;
    }

    /**
     * @return mixed
     */
    public function getJustificaCancela() {
        return $this->justifica_cancela;
    }

    /**
     * @param mixed $justifica_cancela
     */
    public function setJustificaCancela($justifica_cancela) {
        $this->justifica_cancela = $justifica_cancela;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId() {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified) {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getCfOrigem() {
        return $this->cf_origem;
    }

    /**
     * @param mixed $cf_origem
     */
    public function setCfOrigem($cf_origem) {
        $this->cf_origem = $cf_origem;
    }

    /**
     * @return mixed
     */
    public function getBancoOrigem() {
        return $this->banco_origem;
    }

    /**
     * @param mixed $banco_origem
     */
    public function setBancoOrigem($banco_origem) {
        $this->banco_origem = $banco_origem;
    }

    /**
     * @return mixed
     */
    public function getCfDestino() {
        return $this->cf_destino;
    }

    /**
     * @param mixed $cf_destino
     */
    public function setCfDestino($cf_destino) {
        $this->cf_destino = $cf_destino;
    }

    /**
     * @return mixed
     */
    public function getBancoDestino() {
        return $this->banco_destino;
    }

    /**
     * @param mixed $banco_destino
     */
    public function setBancoDestino($banco_destino) {
        $this->banco_destino = $banco_destino;
    }

    public static function getSaldoInicial($conta_financeira_id) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($conta_financeira_id == "" || !isset($conta_financeira_id) || is_null($conta_financeira_id)) {
                $conta_financeira_id = null;
            }
            if (is_null($conta_financeira_id)) {
                throw new \Exception('Conta financeira deve estar preechida');
            }
            $com = $c->prepare("SELECT id, IFNULL(saldo_inicial, 0.00) saldo
                                      FROM contas_financeira
                                      WHERE id = ?
                                        AND empresa_id = ?");
            $com->bind_param(
                    "ii", $conta_financeira_id, $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getUltimoIdPorContaFinanceira($conta_financeira_id) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($conta_financeira_id == "" || !isset($conta_financeira_id) || is_null($conta_financeira_id)) {
                $conta_financeira_id = null;
            }
            if (is_null($conta_financeira_id)) {
                throw new \Exception('Conta financeira deve estar preechida');
            }
            $com = $c->prepare("SELECT id, saldo
                                      FROM movimentacao_saldo
                                      WHERE conta_financ_id = ?
                                        AND empresa_id = ?
                                      ORDER BY id DESC
                                      LIMIT 1");
            $com->bind_param(
                    "ii", $conta_financeira_id, $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getTotaisSaldosProvisaoResgate($tipo_conta, $tipo_operacao) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($tipo_conta == "" || !isset($tipo_conta) || is_null($tipo_conta)) {
                throw new \Exception('Tipo de conta não pode estar vazio');
            }
            if ($tipo_operacao == "" || !isset($tipo_operacao) || is_null($tipo_operacao)) {
                throw new \Exception('Tipo operação de conta não pode estar vazio');
            }
            $com = $c->prepare("SELECT SUM(MS.`valor`) TOTAL
                                      FROM movimentacao_saldo MS
                                      INNER JOIN contas_financeira CF
                                         ON MS.`conta_financ_id` = CF.`id`
                                        AND MS.`empresa_id` = CF.`empresa_id`
                                      WHERE CF.`tipo_conta` = ?
                                        AND MS.`tipo` = ? -- E provisão, S resgate
                                        AND MS.`empresa_id` = ?");
            $com->bind_param(
                    "ssi", $tipo_conta, $tipo_operacao, $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l['TOTAL'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getSaldosProvisaoResgate($tipo_conta, $tipo_operacao) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($tipo_conta == "" || !isset($tipo_conta) || is_null($tipo_conta)) {
                throw new \Exception('Tipo de conta não pode estar vazio');
            }
            if ($tipo_operacao == "" || !isset($tipo_operacao) || is_null($tipo_operacao)) {
                throw new \Exception('Tipo operação de conta não pode estar vazio');
            }
            $com = $c->prepare("SELECT MS.id
                                            ,MS.`data`
                                            ,MS.`valor`
                                            ,MS.`tipo`
                                            ,MS.`saldo`
                                            ,MS.`conta_financ_id`
                                            ,CF.`tipo_conta`
                                            ,CF.`tipo_aplicacao`
                                      FROM movimentacao_saldo MS
                                      INNER JOIN contas_financeira CF
                                        ON MS.`conta_financ_id` = CF.`id`
                                       AND MS.`empresa_id` = CF.`empresa_id`
                                      WHERE CF.`tipo_conta` = ?
                                        AND MS.`tipo` = ? -- E provisão, S resgate
                                        AND MS.`empresa_id` = ?");
            $com->bind_param(
                    "ssi", $tipo_conta, $tipo_operacao, $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            $c->next_result();
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getSaldosPorTipo($tipo_conta) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($tipo_conta == "" || !isset($tipo_conta) || is_null($tipo_conta)) {
                throw new \Exception('Tipo de conta não pode estar vazio');
            }
            $com = $c->prepare("CALL movimentacao_saldo_contas_sel(?, ?)");
            $com->bind_param(
                    "si", $tipo_conta, $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            $c->next_result();
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function seleciona($tipo = null, $cancelado = null) {
        $c = My::con();
        $empresa = EMPRESA;
        if ($tipo == "" || !isset($tipo) || is_null($tipo)) {
            $tipo = null;
        }
        if ($cancelado == "" || !isset($cancelado) || is_null($cancelado)) {
            $cancelado = null;
        }
        $hoje = date('d');
        $dt_fim = date('Y-m-d');
        if ($hoje <= 10) {
            $dt_ini = date('Y-m-d', strtotime('first day of last month'));
        } else {
            $dt_ini = date('Y-m-d', strtotime('first day of this month'));
        }
        $com = $c->prepare("CALL movimentacao_saldo_sel(?,?,?,?,?)");
        $com->bind_param(
                "issss", $empresa, $tipo, $cancelado, $dt_ini, $dt_fim
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

    public static function extrato($conta, $dt_ini, $dt_fim) {
        $c = My::con();
        $empresa = EMPRESA;

        $com = $c->prepare("CALL extrato_bancario(?,?,?,?)");
        $com->bind_param(
                "iiss", $empresa, $conta, $dt_ini, $dt_fim
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            if (count($retorno) == 0) {
                $saldo = $l['saldo'] - $l['valor'];
                $retorno [] = [
                    'id' => $l['id'],
                    'conta' => $l['conta'],
                    'data' => $dt_ini,
                    'descricao' => 'Saldo Anterior',
                    'valor' => '0.00',
                    'saldo' => $saldo,
                    'tipo' => '',
                    'mov_financeira' => ''
                ];
            }
            $retorno[] = $l;
        }
// --->> Função usort() para ordenar os lançamentos em ordem cronológica        
        usort($retorno, function($a, $b) {
            return $a['data'] <=> $b['data'];
        });

        foreach ($retorno as $k => $v) {
            $saldo = ($v['tipo'] == 'C') ? $saldo + $v['valor'] : $saldo - $v['valor'];
            $retorno[$k]['saldo'] = $saldo;
        }

        if ($retorno) {
            $ultimo = count($retorno) - 1;

            $retorno [] = [
                'id' => $l['id'],
                'conta' => $retorno[$ultimo]['conta'],
                'data' => $dt_fim,
                'descricao' => 'SALDO',
                'valor' => '',
                'saldo' => $retorno[$ultimo]['saldo'],
                'tipo' => '',
                'mov_financeira' => ''
            ];
        }

        $c->next_result();
        return $retorno;
    }

    public static function getAnosMovimentacao() {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT DISTINCT YEAR(DATA) ANO
                      FROM movimentacao_saldo
                      WHERE empresa_id = ?
                        AND cancelado = \'N\'';
            $com = $c->prepare($query);
            $com->bind_param(
                    "i", $empresa
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

    public static function getMesesMovimentacaoPorAno($ano) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT DISTINCT MONTH(data) MES
                      FROM movimentacao_saldo
                      WHERE empresa_id = ?
                        AND YEAR(data) = ?
                        AND cancelado = \'N\'';
            $com = $c->prepare($query);
            $com->bind_param(
                    "is", $empresa, $ano
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

    public function salva() {
        try {
            $c = My::con();
            if (!$this->valor) {
                throw new \Exception('O campo valor deve ser preenchido');
            }
            if (!$this->data) {
                throw new \Exception('O campo data deve ser preenchido');
            }
            if (!$this->descricao) {
                throw new \Exception('O campo descrição deve ser preenchido');
            }
            if (!$this->contas_financeira_origem_id) {
                throw new \Exception('O campo conta origem deve estar selecionado');
            }
            if (!$this->contas_financeira_destino_id) {
                throw new \Exception('O campo conta destino deve estar selecionado');
            }
            $com = $c->prepare("CALL movimentacao_saldo_insere(?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "ssiisssiiss", $this->data
                    , $this->descricao
                    , $this->contas_financeira_origem_id
                    , $this->contas_financeira_destino_id
                    , $this->valor
                    , $this->saldo_origem
                    , $this->saldo_destino
                    , $this->user_id
                    , $this->empresa_id
                    , $this->created
                    , $this->modified
            );
            $com->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
