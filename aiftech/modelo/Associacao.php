<?php

namespace modelo;

use bd\My;

class Associacao
{
    private $id;
    private $sigla;
    private $descricao;
    private $ativo;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * Associação constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL associacao_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->sigla = $l["sigla"];
                $this->descricao = $l["descricao"];
                $this->ativo = $l["ativo"];
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
        return $this->id;
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
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param mixed $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
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

    public function alteraStatusAtivo()
    {
        try {
            $c = My::con();
            if (!$this->ativo && !$this->id) {
                throw new \Exception("Problemas com envio de parâmetro.");
            }
            $com = $c->prepare("CALL associacao_altera_status(?,?,?,?,?)");
            $com->bind_param(
                "iisis",
                $this->id,
                $this->empresa_id,
                $this->ativo,
                $this->user_id,
                $this->modified
            );
            $com->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->sigla) {
            throw new \Exception("Sigla obrigatório.");
        }
        if (!$this->descricao) {
            throw new \Exception("Descrição obrigatório.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL associacao_altera(?,?,?,?,?,?)");
            $com->bind_param(
                "issiis",
                $this->id,
                $this->sigla,
                $this->descricao,
                $this->user_id,
                $this->empresa_id,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL associacao_insere(?,?,?,?,?)");
            $com->bind_param(
                "ssiis",
                $this->sigla,
                $this->descricao,
                $this->user_id,
                $this->empresa_id,
                $this->created
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function seleciona($ativo = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $vativo = (is_null($ativo) || $ativo == '' || !isset($ativo)) ? null : $ativo;
        $com = $c->prepare("CALL associacoes_seleciona(?,?)");
        $com->bind_param(
            "is",
            $empresa,
            $vativo
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
}