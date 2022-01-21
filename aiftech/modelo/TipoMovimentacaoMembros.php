<?php

namespace modelo;

use bd\My;

class TipoMovimentacaoMembros
{
    private $id;
    private $nome;
    private $membros_frequencia_id;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    public function __construct($id = null)
    {
        try {
            if (!is_null($id)) {
                $id = \bd\Formatos::inteiro($id);
                $c = My::con();
                $empresa = EMPRESA;
                $r = $c->query("SELECT *
                                      FROM tipo_movimentacao_membro
                                      WHERE id = $id
                                        AND empresa_id = $empresa");
                $l = $r->fetch_assoc();
                if ($l) {
                    $this->id = $id;
                    $this->nome = $l['nome'];
                    $this->empresa_id = $l["empresa_id"];
                    $this->membros_frequencia_id = $l['membros_frequencia_id'];
                    $this->user_id = $l["user_id"];
                    $this->created = $l["created"];
                    $this->modified = $l["modified"];
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * @return int
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
        $this->id = $id;
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
    public function getMembrosFrequenciaId()
    {
        return $this->membros_frequencia_id;
    }

    /**
     * @param mixed $membros_frequencia_id
     */
    public function setMembrosFrequenciaId($membros_frequencia_id)
    {
        $this->membros_frequencia_id = $membros_frequencia_id;
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
        $this->empresa_id = $empresa_id;
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
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }
}