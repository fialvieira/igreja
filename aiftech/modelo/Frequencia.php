<?php

namespace modelo;

use bd\My;

class Frequencia
{
    private $id;
    private $frequencia;
    private $status;
    private $quorum;

    /**
     * Frequencia constructor.
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("CALL membros_frequencia_seleciona($id, $empresa)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->frequencia = $l["frequencia"];
                $this->status = $l["status"];
                $this->quorum = $l["quorum"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getQuorum()
    {
        return $this->quorum;
    }

    /**
     * @param mixed $quorum
     */
    public function setQuorum($quorum)
    {
        $this->quorum = $quorum;
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
    public function getFrequencia()
    {
        return $this->frequencia;
    }

    /**
     * @param mixed $id
     */
    public function setFrequencia($frequencia)
    {
        $this->frequencia = $frequencia;
    }

    public static function seleciona($id = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($id === '' || is_null($id) || empty($id)) {
            $id_f = 'null';
        } else {
            $id_f = $id;
        }

        $r = $c->query("CALL membros_frequencia_seleciona($id_f, $empresa)");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }
}