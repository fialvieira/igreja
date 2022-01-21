<?php

namespace modelo;

use bd\My;

class MovimentacaoFinanceira
{

    private $id;
    private $tipo;
    private $data;
    private $descricao;
    private $documento;
    private $categoria_financeira_id;
    private $valor;
    private $centro_custo_id;
    private $membro_id;
    private $membro_nome;
    private $cancelado;
    private $user_cancela;
    private $justifica_cancela;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $contas_financeira_id;
    private $compras_id;

    const TIPO_ENTRADA = 'E';
    const TIPO_SAIDA = 'S';
    const TIPOS = [
        'E' => 'Entrada (Receita)',
        'S' => 'Saída (Despesa)'
    ];

    /**
     * CategoriasFinanceira constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL movimentacao_financeira_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->tipo = $l["tipo"];
                $this->data = $l["data"];
                $this->descricao = $l["descricao"];
                $this->documento = $l["documento"];
                $this->categoria_financeira_id = $l["categoria_financeira_id"];
                $this->valor = $l["valor"];
                $this->centro_custo_id = $l["centro_custo_id"];
                $this->membro_id = $l["membro_id"];
                $this->membro_nome = $l["membro_nome"];
                $this->cancelado = $l["cancelado"];
                $this->user_cancela = $l["user_id_cancela"];
                $this->justifica_cancela = $l["justifica_cancela"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->contas_financeira_id = $l["contas_financeira_id"];
                $this->compras_id = $l["compras_id"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getComprasId()
    {
        return $this->compras_id;
    }

    /**
     * @param mixed $compras_id
     */
    public function setComprasId($compras_id)
    {
        $this->compras_id = $compras_id;
    }

    /**
     * @return mixed
     */
    public function getCategoriaFinanceiraId()
    {
        return $this->categoria_financeira_id;
    }

    /**
     * @param mixed $categoria_financeira_id
     */
    public function setCategoriaFinanceiraId($categoria_financeira_id)
    {
        $this->categoria_financeira_id = $categoria_financeira_id;
    }

    /**
     * @return mixed
     */
    public function getCentroCustoId()
    {
        return $this->centro_custo_id;
    }

    /**
     * @param mixed $centro_custo_id
     */
    public function setCentroCustoId($centro_custo_id)
    {
        $this->centro_custo_id = $centro_custo_id;
    }

    /**
     * @return mixed
     */
    public function getMembroNome()
    {
        return $this->membro_nome;
    }

    /**
     * @param mixed $membro_nome
     */
    public function setMembroNome($membro_nome)
    {
        $this->membro_nome = $membro_nome;
    }

    /**
     * @return mixed
     */
    public function getContasFinanceiraId()
    {
        return $this->contas_financeira_id;
    }

    /**
     * @param mixed $contas_financeira_id
     */
    public function setContasFinanceiraId($contas_financeira_id)
    {
        $this->contas_financeira_id = $contas_financeira_id;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return \bd\Formatos::dataApp($this->data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = \bd\Formatos::dataBd($data);
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return mixed
     */
    public function getCategoriaFinanceira()
    {
        return $this->categoria_financeira_id;
    }

    /**
     * @param mixed $categoria_financeira_id
     */
    public function setCategoriaFinanceira($categoria_financeira_id)
    {
        $this->categoria_financeira_id = \bd\Formatos::inteiro($categoria_financeira_id);
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return \bd\Formatos::moeda($this->valor);
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = \bd\Formatos::real($valor);
    }

    /**
     * @return mixed
     */
    public function getCentroCusto()
    {
        return $this->centro_custo_id;
    }

    /**
     * @param mixed $centro_custo_id
     */
    public function setCentroCusto($centro_custo_id)
    {
        $this->centro_custo_id = \bd\Formatos::inteiro($centro_custo_id);
    }

    /**
     * @return mixed
     */
    public function getMembroId()
    {
        return $this->membro_id;
    }

    /**
     * @param mixed $membro_id
     */
    public function setMembroId($membro_id)
    {
        $this->membro_id = \bd\Formatos::inteiro($membro_id);
    }

    /**
     * @return mixed
     */
    public function getMembro()
    {
        return $this->membro_nome;
    }

    /**
     * @return mixed
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * @param mixed $cancelado
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
    }

    /**
     * @return mixed
     */
    public function getUser_cancela()
    {
        return $this->user_cancela;
    }

    /**
     * @param mixed $user_cancela
     */
    public function setUser_cancela($user_cancela)
    {
        $this->user_cancela = \bd\Formatos::inteiro($user_cancela);
    }

    /**
     * @return mixed
     */
    public function getJustifica_cancela()
    {
        return $this->justifica_cancela;
    }

    /**
     * @param mixed $justifica_cancela
     */
    public function setJustifica_cancela($justifica_cancela)
    {
        $this->justifica_cancela = $justifica_cancela;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
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
        return $this->user_id;
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

    public function cancelaMovimentacaoFinanceira()
    {
        try {
            $c = My::con();
            if (!$this->id) {
                throw new \Exception('É necessário passar o parâmetro ID.');
            }
            $com = $c->prepare("UPDATE movimentacao_financeira
                                      SET cancelado = 'S'
                                         ,user_id = ?
                                         ,modified = ?
                                      WHERE id = ?
                                        AND empresa_id = ?;");
            $com->bind_param(
                "isii",
                $this->user_id,
                $this->modified,
                $this->id,
                $this->empresa_id
            );
            $com->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->tipo && !$this->cancelado) {
            throw new \Exception("Tipo obrigatório.");
        }

        if (!$this->data) {
            throw new \Exception("Data Movimenação obrigatória.");
        }

        if (!$this->descricao) {
            throw new \Exception("Descrição obrigatória.");
        }

        if (!$this->categoria_financeira_id) {
            throw new \Exception("Conta obrigatória.");
        }

        if (!$this->valor) {
            throw new \Exception("Valor obrigatório.");
        }

        if (!$this->centro_custo_id) {
            throw new \Exception("Centro Custo obrigatório.");
        }
        if ($this->id) {
            $com = $c->prepare("CALL movimentacao_financeira_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssidiisisiisii",
                $this->id,
                $this->tipo,
                $this->data,
                $this->descricao,
                $this->documento,
                $this->categoria_financeira_id,
                $this->valor,
                $this->centro_custo_id,
                $this->membro_id,
                $this->cancelado,
                $this->user_cancela,
                $this->justifica_cancela,
                $this->empresa_id,
                $this->user_id,
                $this->modified,
                $this->contas_financeira_id,
                $this->compras_id
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL movimentacao_financeira_insere(?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssssidiiiisii",
                $this->tipo,
                $this->data,
                $this->descricao,
                $this->documento,
                $this->categoria_financeira_id,
                $this->valor,
                $this->centro_custo_id,
                $this->membro_id,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->contas_financeira_id,
                $this->compras_id
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->id = $l["id"];
            $c->next_result();
        }
    }

    public static function seleciona($tipo = null, $cancelado = null)
    {
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
//    $r = $c->query("CALL movimentacao_financeira_sel($empresa,'$cancelado')");
        $com = $c->prepare("CALL movimentacao_financeira_sel(?,?,?,?,?)");
        $com->bind_param(
            "issss", $empresa, $tipo, $cancelado, $dt_ini, $dt_fim
        );
        $com->execute();
        $r = $com->get_result();
//    $l = $r->fetch_assoc();

        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function getAnosMovimentacao()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT DISTINCT YEAR(DATA) ANO
                      FROM movimentacao_financeira
                      WHERE empresa_id = ?
                      ORDER BY ANO DESC';
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

    public static function getMesesMovimentacaoPorAno($ano)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT DISTINCT MONTH(data) MES
                      FROM movimentacao_financeira
                      WHERE empresa_id = ?
                        AND YEAR(data) = ?';
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

    public static function getMovimentoAnterior($ano, $mes_referencia, $tipo_movimento)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT IFNULL(SUM(valor), 0) TOTAL
                      FROM movimentacao_financeira
                      WHERE empresa_id = ?
                        AND YEAR(`data`) = ?
                        AND MONTH(`data`) < ?
                        AND tipo = ?
                        AND cancelado = \'N\'';
            $com = $c->prepare($query);
            $com->bind_param(
                "isis", $empresa, $ano, $mes_referencia, $tipo_movimento
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l['TOTAL'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getMovimentoAtual($ano, $mes_referencia, $tipo_movimento)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT IFNULL(SUM(valor), 0) TOTAL
                      FROM movimentacao_financeira
                      WHERE empresa_id = ?
                        AND YEAR(`data`) = ?
                        AND MONTH(`data`) = ?
                        AND tipo = ?
                        AND cancelado = \'N\'';
            $com = $c->prepare($query);
            $com->bind_param(
                "isis", $empresa, $ano, $mes_referencia, $tipo_movimento
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l['TOTAL'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

//----> ARQUIVOS  
    public static function selecionaArquivos($movimentacao_financeira, $id = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if (is_null($id)) {
            $query = 'CALL movimentacao_financeira_arquivos_seleciona(?,?)';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii", $empresa, $movimentacao_financeira
            );
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
        } else {
            $r = $c->query("CALL movimentacao_financeira_arquivo_seleciona($empresa, $id)");
            $retorno = $r->fetch_assoc();
        }
        $c->next_result();
        return $retorno;
    }

    public function salvaArquivo($path, $nome)
    {
        $c = My::con();
        $hoje = date('Y-m-d');

        if (is_null($this->id)) {
            throw new \Exception("Movimentação Financeira obrigatório.");
        }

        if (is_null($nome) || empty($nome) || $nome == '') {
            throw new \Exception("Nome obrigatório.");
        }

        if (is_null($path) || empty($path) || $path == '') {
            throw new \Exception("Path obrigatório.");
        }

        $com = $c->prepare("CALL movimentacao_financeira_arquivo_insere(?,?,?,?,?,?,?)");
        $com->bind_param(
            "isssiis", $this->id, $path, $nome, $hoje, $this->user_id, $this->empresa_id, $this->created
        );
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();

        $c->next_result();
        return $l;
    }

    public function excluiArquivo($id)
    {
        $c = My::con();

        if ($id) {
            $com = $c->prepare("CALL movimentacao_financeira_arquivo_exclui(?,?)");
            $com->bind_param(
                "ii", $this->empresa_id, $id
            );
            $com->execute();
        }
    }

//<---
    public static function listaMovimentacoesPorCompra($compra_id, $tipo = null, $cancelado = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT T1.*
                              ,T2.nome categoria_financeira
                              ,T3.descricao centro_custo
                              ,T4.nome contribuinte
                              ,CONCAT(T5.nome, \' - \', T6.nome) conta_financeira
                        FROM movimentacao_financeira T1
                        LEFT JOIN categorias_financeira T2
                               ON T1.categoria_financeira_id = T2.id
                        LEFT JOIN centro_custo T3
                               ON T1.centro_custo_id = T3.id
                        LEFT JOIN membros T4
                               ON T1.membro_id = T4.id
                        LEFT JOIN contas_financeira T5
                            ON T1.contas_financeira_id = T5.id
                        LEFT JOIN bancos T6
                            ON T5.banco_id = T6.id
                        WHERE T1.empresa_id = ?
                          AND T1.`compras_id` = ?
                          AND T1.tipo = CASE IFNULL(?,\'\')
                                    WHEN \'\' THEN T1.tipo
                                    ELSE ?
                                END
                          AND IFNULL(T1.cancelado,\'N\') = CASE IFNULL(?,\'\')
                                            WHEN \'\' THEN IFNULL(T1.cancelado,\'N\')
                                            ELSE ?
                                         END
                        ORDER BY T1.tipo, T1.data DESC';
            $com = $c->prepare($query);
            $com->bind_param(
                "iissss", $empresa, $compra_id, $tipo, $tipo, $cancelado, $cancelado
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

}
