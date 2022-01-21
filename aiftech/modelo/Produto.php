<?php

namespace modelo;

use bd\Formatos;
use bd\My;

class Produto
{
    private $id;
    private $nome;
    private $descricao;
    private $unidade_medida;
    private $ativo;
    private $categoria;
    private $tipo_produto_id;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    const g = 1;
    const mg = 2;
    const kg = 3;
    const m = 4;
    const ml = 5;
    const l = 6;
    const unidades = 7;
    const horas = 8;
    const UNIDADES_MEDIDAS = [
        1 => 'g',
        2 => 'mg',
        3 => 'kg',
        4 => 'm',
        5 => 'ml',
        6 => 'l',
        7 => 'unidades',
        8 => 'horas'
    ];

    const PRODUTO = 'P';
    const SERVICO = 'S';
    const TIPOS = [
        'P' => 'Produto',
        'S' => 'Serviço'
    ];

    /**
     * TipoBem constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $empresa = EMPRESA;
            $c = My::con();
            $r = $c->query("SELECT *
                                   FROM produtos
                                   WHERE id = $id
                                     AND empresa_id = $empresa");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->descricao = $l["descricao"];
                $this->unidade_medida = $l["unidade_medida"];
                $this->ativo = $l["ativo"];
                $this->categoria = $l["tipo"];
                $this->tipo_produto_id = $l["tipo_produto_id"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return Formatos::inteiro($this->id);
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getTipoProdutoId()
    {
        return Formatos::inteiro($this->tipo_produto_id);
    }

    /**
     * @param mixed $tipo_produto_id
     */
    public function setTipoProdutoId($tipo_produto_id)
    {
        $this->tipo_produto_id = Formatos::inteiro($tipo_produto_id);
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
        if ($this->id) {
            $this->nome = $nome;
        } else {
            $valido = self::validaProduto($nome);
            if ($valido) {
                $this->nome = $nome;
            } else {
                throw new \Exception('Já existe produto cadastrado com o mesmo nome');
            }
        }
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
    public function getUnidadeMedida()
    {
        return $this->unidade_medida;
    }

    /**
     * @param mixed $unidade_medida
     */
    public function setUnidadeMedida($unidade_medida)
    {
        $this->unidade_medida = $unidade_medida;
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
    public function getEmpresaId()
    {
        return Formatos::inteiro($this->empresa_id);
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = Formatos::inteiro($empresa_id);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return Formatos::inteiro($this->user_id);
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = Formatos::inteiro($user_id);
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = Formatos::dataHoraBd($modified);
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL produto_altera(?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssiiiss",
                $this->id,
                $this->nome,
                $this->descricao,
                $this->unidade_medida,
                $this->categoria,
                $this->tipo_produto_id,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL produto_insere(?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssssiiiss",
                $this->nome,
                $this->descricao,
                $this->unidade_medida,
                $this->categoria,
                $this->tipo_produto_id,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function gravaFornecedores($produto_id, $fornecedor_id, $user_id, $created, $modified)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "INSERT INTO assoc_fornecedores_produtos (fornecedores_id, produtos_id, empresa_id, user_id, created, modified)
													   VALUES (?, ?, ?, ?, ?, ?)";
            $com = $c->prepare($query);
            $com->bind_param(
                "iiiiss",
                $fornecedor_id,
                $produto_id,
                $empresa,
                $user_id,
                $created,
                $modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            dd($exc->getMessage());
        }
    }

    public static function excluiFornecedores($id)
    {
        try {
            $empresa = EMPRESA;
            $c = My::con();
            $query = 'DELETE
                      FROM assoc_fornecedores_produtos
                      WHERE produtos_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii",
                $id,
                $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function selecionaFornecedoresAtivos($id)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("SELECT f.*
                                  FROM fornecedores f
                                  INNER JOIN assoc_fornecedores_produtos afp
                                    ON f.`id` = afp.`fornecedores_id`
                                   AND f.`empresa_id` = afp.`empresa_id`
                                  WHERE afp.`produtos_id` = $id
                                    AND f.`empresa_id` = $empresa
                                    AND f.`ativo` = 'S'");
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function seleciona()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("SELECT p.*
                                    ,tp.`nome` tipo_produto
                               FROM produtos p
                               LEFT JOIN tipo_produtos tp
                                ON p.`tipo_produto_id` = tp.`id`
                               AND p.`empresa_id` = tp.`empresa_id`
                               WHERE p.empresa_id = $empresa");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public function alteraStatusAtivo()
    {
        try {
            $c = My::con();
            if (!$this->ativo && !$this->id) {
                throw new \Exception("Problemas com envio de parâmetro.");
            }
            $com = $c->prepare("CALL produto_altera_status(?,?,?,?,?,?)");
            $com->bind_param(
                "iisiss",
                $this->id,
                $this->empresa_id,
                $this->ativo,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function validaProduto($nome)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("SELECT COUNT(*) TOTAL
                               FROM produtos
                               WHERE empresa_id = $empresa
                                 AND nome LIKE '$nome%'");
        $l = $r->fetch_assoc();
        if ($l['TOTAL'] != 0) {
            return false;
        } else {
            return true;
        }
    }
}