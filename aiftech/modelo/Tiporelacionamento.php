<?php

namespace modelo;

use bd\My;

class Tiporelacionamento
{
    private $id;
    private $descricao;
    private $obs;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Tiporelacionamento constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL tiporelacionamento_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->descricao = $l["descricao"];
                $this->obs = $l["obs"];
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
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
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
        if (!$this->descricao) {
            throw new \Exception("Descricao obrigatório(a).");
        }

        if (!$this->empresa_id) {
            throw new \Exception("Empresa Id obrigatório(a).");
        }

        if (!$this->user_id) {
            throw new \Exception("User Id obrigatório(a).");
        }

        if (!$this->created) {
            throw new \Exception("Created obrigatório(a).");
        }

        if (!$this->modified) {
            throw new \Exception("Modified obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL tiporelacionamento_altera(?,?,?,?,?,?,?)");
            $com->bind_param(
                "issiiss",
                $this->id,
                $this->descricao,
                $this->obs,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL tiporelacionamento_insere(?,?,?,?,?,?)");
            $com->bind_param(
                "ssiiss",
                $this->descricao,
                $this->obs,
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
        $r = $c->query("SELECT *
                               FROM tipo_relacionamentos
                               WHERE id <> 4");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }
}