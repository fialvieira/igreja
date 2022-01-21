<?php

namespace modelo;

use bd\My;

class ContasFinanceira
{
    private $id;
    private $nome;
    private $descricao;
    private $banco_id;
    private $agencia;
    private $numero;
    private $variacao;
    private $tipo_conta;
    private $tipo_aplicacao;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $ativo;
    private $saldo_inicial;

    /**
     * ContasFinanceira constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $empresa = EMPRESA;
            $c = My::con();
            $r = $c->query("CALL conta_financeira_seleciona($id, $empresa)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->descricao = $l["descricao"];
                $this->banco_id = $l["banco_id"];
                $this->agencia = $l["agencia"];
                $this->numero = $l["numero"];
                $this->variacao = $l["variacao"];
                $this->tipo_conta = $l["tipo_conta"];
                $this->tipo_aplicacao = $l["tipo_aplicacao"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->ativo = $l["ativo"];
                $this->saldo_inicial = $l["saldo_inicial"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getSaldoInicial()
    {
        return $this->saldo_inicial;
    }

    /**
     * @param mixed $saldo_inicial
     */
    public function setSaldoInicial($saldo_inicial)
    {
        $this->saldo_inicial = $saldo_inicial;
    }

    /**
     * @return mixed
     */
    public function getNomeBanco()
    {
        try {
            if ($this->id && $this->banco_id) {
                $c = My::con();
                $r = $c->query("SELECT nome
                                      FROM bancos
                                      WHERE id = $this->banco_id;");
                $l = $r->fetch_assoc();
                return $l['nome'];
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
    public function getBancoId()
    {
        return \bd\Formatos::inteiro($this->banco_id);
    }

    /**
     * @param mixed $banco_id
     */
    public function setBancoId($banco_id)
    {
        $this->banco_id = \bd\Formatos::inteiro($banco_id);
    }

    /**
     * @return mixed
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param mixed $agencia
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getVariacao()
    {
        return $this->variacao;
    }

    /**
     * @param mixed $variacao
     */
    public function setVariacao($variacao)
    {
        $this->variacao = $variacao;
    }

    /**
     * @return mixed
     */
    public function getTipoConta()
    {
        return $this->tipo_conta;
    }

    /**
     * @param mixed $tipo_conta
     */
    public function setTipoConta($tipo_conta)
    {
        $this->tipo_conta = $tipo_conta;
    }

    /**
     * @return mixed
     */
    public function getTipoAplicacao()
    {
        return $this->tipo_aplicacao;
    }

    /**
     * @param mixed $tipo_aplicacao
     */
    public function setTipoAplicacao($tipo_aplicacao)
    {
        $this->tipo_aplicacao = $tipo_aplicacao;
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

    public function alteraAtivo()
    {
        try {
            if ($this->id) {
                $c = My::con();
                $query = 'UPDATE contas_financeira
                          SET ativo = ?
                             ,user_id = ?
                             ,modified = ?
                          WHERE id = ?
                            AND empresa_id = ?';
                $com = $c->prepare($query);
                $com->bind_param('sisii',
                    $this->ativo
                    , $this->user_id
                    , $this->modified
                    , $this->id
                    , $this->empresa_id);
                $com->execute();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }

        /*if (!$this->tipo_conta) {
            throw new \Exception("Tipo Conta obrigatório(a).");
        }*/

        if ($this->id) {
            $com = $c->prepare("CALL contas_financeira_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ississsssiisss",
                $this->id,
                $this->nome,
                $this->descricao,
                $this->banco_id,
                $this->agencia,
                $this->numero,
                $this->variacao,
                $this->tipo_conta,
                $this->tipo_aplicacao,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified,
                $this->saldo_inicial
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL contas_financeira_insere(?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssisssssiisss",
                $this->nome,
                $this->descricao,
                $this->banco_id,
                $this->agencia,
                $this->numero,
                $this->variacao,
                $this->tipo_conta,
                $this->tipo_aplicacao,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified,
                $this->saldo_inicial
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function seleciona()
    {
        try {
            $c = My::con();
            $r = $c->query("CALL contas_financeira_seleciona(" . EMPRESA . ")");
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
}