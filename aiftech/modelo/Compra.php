<?php

namespace modelo;

use bd\My;
use mysql_xdevapi\Exception;

class Compra
{

    const APROVADO = 'A';
    const RECUSADO = 'R';
    const SOLICITADO = 'S';
    const PRE_APROVADO = 'P';
    const EXECUTADO = 'E';
    const FILTRADO = 'F';
    const SITUACAO = [
        'A' => 'Aprovado',
        'R' => 'Recusado',
        'S' => 'Solicitado',
        'P' => 'Pré-Aprovado',
        'E' => 'Executado',
        'F' => 'Filtrado'
    ];

    private $id;
    private $data_solicitacao;
    private $situacao;
    private $justificativa;
    private $categoria_financeira;
    private $solicitante;
    private $solicitante_nome;
    private $autorizador;
    private $autorizador_nome;
    private $dt_autorizacao;
    private $valor;
    private $fornecedor;
    private $nota_fiscal;
    private $dt_nota_fiscal;
    private $valor_nota_fiscal;
    private $observacoes;
    private $path_nota;
    private $parcelas_nota;
    private $meios_pagamento;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * Compra constructor.
     * @param int $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $empresa = EMPRESA;
            $c = My::con();
            $r = $c->query("CALL compra_seleciona($id, $empresa)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->data_solicitacao = $l["data_solicitacao"];
                $this->situacao = $l["situacao"];
                $this->justificativa = $l["justificativa"];
                $this->categoria_financeira = $l["categoria_financeira_id"];
                $this->solicitante = $l["solicitante_id"];
                $this->solicitante_nome = $l["solicitante_nome"];
                $this->autorizador = $l["autorizador_id"];
                $this->autorizador_nome = $l["autorizador_nome"];
                $this->dt_autorizacao = $l["data_autorizacao"];
                $this->fornecedor = $l["fornecedor_id"];
                $this->nota_fiscal = $l["numero_nota"];
                $this->dt_nota_fiscal = $l["data_nota"];
                $this->valor_nota_fiscal = $l["valor_nota"];
                $this->observacoes = $l["observacao"];
                $this->path_nota = $l['path_nota'];
                $this->user_id = $l["user_id"];
                $this->empresa_id = $l["empresa_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->parcelas_nota = $l["qtd_parcelas"];
                $this->meios_pagamento = $l["meio_pagamento_id"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getParcelasNota()
    {
        return $this->parcelas_nota;
    }

    /**
     * @param mixed $parcelas_nota
     */
    public function setParcelasNota($parcelas_nota)
    {
        $this->parcelas_nota = $parcelas_nota;
    }

    /**
     * @return mixed
     */
    public function getMeiosPagamento()
    {
        return $this->meios_pagamento;
    }

    /**
     * @param mixed $meios_pagamento
     */
    public function setMeiosPagamento($meios_pagamento)
    {
        $this->meios_pagamento = $meios_pagamento;
    }

    /**
     * @return mixed
     */
    public function getDataSolicitacao()
    {
        return $this->data_solicitacao;
    }

    /**
     * @param mixed $data_solicitacao
     */
    public function setDataSolicitacao($data_solicitacao)
    {
        $this->data_solicitacao = $data_solicitacao;
    }

    /**
     * @return mixed
     */
    public function getPathNota()
    {
        return $this->path_nota;
    }

    /**
     * @param mixed $path_nota
     */
    public function setPathNota($path_nota)
    {
        $this->path_nota = $path_nota;
    }

    /**
     * @return int Id da compra
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return date Data da solicitação
     */
    public function getDtSolicitacao()
    {
        return \bd\Formatos::dataApp($this->data_solicitacao);
    }

    /**
     * @param date $data_solicitacao
     */
    public function setDtSolicitacao($data_solicitacao)
    {
        $this->data_solicitacao = \bd\Formatos::dataBd($data_solicitacao);
    }

    /**
     * @return string Situação da solicitação de compra
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param string $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    /**
     * @return string Justificativa para realizar a compra
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * @param string $justificativa
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
    }

    /**
     * @return int Id da Categoria Financeira
     */
    public function getCategoriaFinanceira()
    {
        return $this->categoria_financeira;
    }

    /**
     * @param int $categoria_financeira_id
     */
    public function setCategoriaFinanceira($categoria_financeira_id)
    {
        $this->categoria_financeira = $categoria_financeira_id;
    }

    /**
     * @return int Id do Solicitante
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * @param int $solicitante
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
    }

    /**
     * @return string Nome do Solicitante
     */
    public function getSolicitanteNome()
    {
        return $this->solicitante_nome;
    }

    /**
     * @return int Id do Autorizador, podendo ser o Presidente ou Pastor
     */
    public function getAutorizador()
    {
        return $this->autorizador;
    }

    /**
     * @param int $autorizador
     */
    public function setAutorizador($autorizador)
    {
        $this->autorizador = $autorizador;
    }

    /**
     * @return string Nome do Autorizador, podendo ser o Presidente ou Pastor
     */
    public function getAutorizadorNome()
    {
        return $this->autorizador_nome;
    }

    /**
     * @return date Data da Autorização pelo Presidente ou Pastor
     */
    public function getDtAutorizacao()
    {
        return \bd\Formatos::dataHoraApp($this->dt_autorizacao);
    }

    /**
     * @param date $dt_autorizacao
     */
    public function setDtAutorizacao($dt_autorizacao)
    {
        $this->dt_autorizacao = \bd\Formatos::dataHoraBd($dt_autorizacao);
    }

    /**
     * @return moeda Valor da Compra
     */
    public function getValor()
    {
        return \bd\Formatos::moeda($this->valor);
    }

    /**
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = \bd\Formatos::real($valor);
    }

    /**
     * @return int Id do Fornecedor do orçamento Aprovado
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * @param int $fornecedor
     */
    public function setFornecedor($fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * @return string Número da Nota Fiscal aprovada
     */
    public function getNotaFiscal()
    {
        return $this->nota_fiscal;
    }

    /**
     * @param string $nota_fiscal
     */
    public function setNotaFiscal($nota_fiscal)
    {
        $this->nota_fiscal = $nota_fiscal;
    }

    /**
     * @return date Data da Nota Fiscal aprovada
     */
    public function getDtNotaFiscal()
    {
        return \bd\Formatos::dataApp($this->dt_nota_fiscal);
    }

    /**
     * @param date $dt_nota_fiscal
     */
    public function setDtNotaFiscal($dt_nota_fiscal)
    {
        $this->dt_nota_fiscal = \bd\Formatos::dataBd($dt_nota_fiscal);
    }

    /**
     * @return moeda Valor da Nota Fiscal aprovada
     */
    public function getValorNotaFiscal()
    {
        return \bd\Formatos::moeda($this->valor_nota_fiscal);
    }

    /**
     * @param float $valor_nota_fiscal
     */
    public function setValorNotaFiscal($valor_nota_fiscal)
    {
        $this->valor_nota_fiscal = \bd\Formatos::real($valor_nota_fiscal);
    }

    /**
     * @return string Observações da Compra
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param string $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * @return int Usuário que inseriou / editou
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = \bd\Formatos::inteiro($user_id);
    }

    /**
     * @return int empresa responsável
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    /**
     * @param int $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
    }

    /**
     * @return datetime data de criação/inserção
     */
    public function getCreated()
    {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return datetime data de modificação
     */
    public function getModified()
    {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param datetime $modified
     */
    public function setModified($modified)
    {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    public function mudaSituacao($situacao)
    {
        try {
            $c = My::con();
            if ($this->id) {
                $com = $c->prepare("UPDATE compras
                                          SET situacao = ?
                                             ,user_id = ?
                                             ,modified = ?
                                          WHERE id = ?
                                            AND empresa_id = ?");
                $com->bind_param(
                    "sisii", $situacao
                    ,$this->user_id
                    ,$this->modified
                    , $this->id
                    ,$this->empresa_id
                );
                $com->execute();
            } else {
                throw new \Exception('Necessário o parâmetro ID.');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Função para salvar / alterar solicitação de compra
     */
    public function salva_solicitacao()
    {
        $c = My::con();
        $situacao = 'S'; //--> solicitado
//        dd($this->id);
        if ($this->id) {
            $com = $c->prepare("CALL solicitacao_compra_altera(?,?,?,?,?,?,?)");
            $com->bind_param(
                "issiiis", $this->id, $situacao, $this->justificativa, $this->categoria_financeira, $this->user_id,
                $this->empresa_id, $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL solicitacao_compra_insere(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "sssiiiis", $this->data_solicitacao, $situacao, $this->justificativa, $this->categoria_financeira,
                $this->solicitante, $this->user_id, $this->empresa_id, $this->created
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public function salvaDadosNota()
    {
        try {
            $c = My::con();
            if ($this->id) {
                $com = $c->prepare("CALL compra_nota_altera(?,?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "issssiisiis",
                    $this->id,
                    $this->dt_nota_fiscal,
                    $this->nota_fiscal,
                    $this->valor_nota_fiscal,
                    $this->observacoes,
                    $this->parcelas_nota,
                    $this->meios_pagamento,
                    $this->path_nota,
                    $this->user_id,
                    $this->empresa_id,
                    $this->modified
                );
                $com->execute();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function selecionaComprasAprovadas($solicitante = null, $data_ini = null, $data_fim = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($data_ini) || $data_ini == '' || empty($data_ini)) {
                $data_ini = '2017-01-01 00:00:00';
                $data_fim = date('Y-12-31 23:59:59');
            }
            $com = $c->prepare("CALL contas_pagar_solicitacao_seleciona(?,?,?,?)");
            $com->bind_param(
                "iiss", $empresa, $solicitante, $data_ini, $data_fim);
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

    /**
     * Função estática que retorna as compras
     * @param int $solicitante
     * @param date $data_ini
     * @param date $data_fim
     * @param char $situacao
     * @return array Lista de compras
     * @throws \Exception
     */
    public static function seleciona($solicitante = null, $data_ini = null, $data_fim = null, $situacao = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($data_ini) || $data_ini == '') {
                $data_ini = '2017-01-01 00:00:00';
                $data_fim = date('Y-12-31 23:59:59');
            }
            $com = $c->prepare("CALL compras_seleciona(?,?,?,?,?)");
            $com->bind_param(
                "iisss", $empresa, $solicitante, $data_ini, $data_fim, $situacao);
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

    /**
     * Função estática que retorna lista de solicitantes da igreja (empresa)
     * @return array Lista de solicitantes
     * @throws \Exception
     */
    public static function listaSolicitantes()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT DISTINCT solicitante_id, M.`nome`
                      FROM compras C
                      INNER JOIN membros M
                         ON C.`solicitante_id` = M.`id`
                        AND C.`empresa_id` = M.`empresa_id`
                        AND C.`empresa_id` = ?";
            $com = $c->prepare($query);
            $com->bind_param("i", $empresa);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Função para salvar / alterar a situação do pedido de compra
     * @throws \Exception
     */
    public function alteraSituacao()
    {
        try {
            if (!$this->id) {
                throw new Exception('Não foi possível encontrar este pedido.');
            }
            $c = My::con();
            $com = $c->prepare("CALL compras_situacao_upd(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "iiisssis",
                $this->id,
                $this->empresa_id,
                $this->autorizador,
                $this->dt_autorizacao,
                $this->observacoes,
                $this->situacao,
                $this->user_id,
                $this->modified
            );
            $com->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function excluiArquivoNota()
    {
        try {
            if (!$this->id) {
                throw new Exception('Não foi possível encontrar este pedido.');
            }
            $c = My::con();
            $this->path_nota = null;
            $com = $c->prepare("UPDATE compras
                                        SET path_nota = ?
                                           ,user_id = ?
                                           ,modified = ?
                                        WHERE id = ?
                                          AND empresa_id = ?");
            $com->bind_param(
                "sisii",
                $this->path_nota,
                $this->user_id,
                $this->modified,
                $this->id,
                $this->empresa_id
            );
            $com->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}