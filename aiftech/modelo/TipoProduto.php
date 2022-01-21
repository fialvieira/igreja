<?php


namespace modelo;

use bd\My;

class TipoProduto
{
    private $id;
    private $nome;
    private $descricao;
    private $ativo;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

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
                                   FROM tipo_produtos
                                   WHERE id = $id
                                     AND empresa_id = $empresa");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->descricao = $l["descricao"];
                $this->ativo = $l["ativo"];
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
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL tipo_produto_altera(?,?,?,?,?,?,?)");
            $com->bind_param(
                "issiiss",
                $this->id,
                $this->nome,
                $this->descricao,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL tipo_produto_insere(?,?,?,?,?,?)");
            $com->bind_param(
                "ssiiss",
                $this->nome,
                $this->descricao,
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

    public static function seleciona()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("SELECT *
                               FROM tipo_produtos
                               WHERE empresa_id = $empresa");
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
            $com = $c->prepare("CALL tipo_produto_altera_status(?,?,?,?,?,?)");
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
                               FROM tipo_produtos
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