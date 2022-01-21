<?php

namespace modelo;

use bd\My;

class Estado
{

    private $id;
    private $sigla;
    private $codibge;
    private $nome;

    /**
     * Estado constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL estado_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->sigla = $l["sigla"];
                $this->codibge = $l["codibge"];
                $this->nome = $l["nome"];
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
    public function getCodibge()
    {
        return \bd\Formatos::inteiro($this->codibge);
    }

    /**
     * @param mixed $codibge
     */
    public function setCodibge($codibge)
    {
        $this->codibge = \bd\Formatos::inteiro($codibge);
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

    public function salva()
    {
        $c = My::con();
        if (!$this->sigla) {
            throw new \Exception("Sigla obrigatório(a).");
        }

        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL estado_altera(?,?,?,?)");
            $com->bind_param(
                "isis", $this->id, $this->sigla, $this->codibge, $this->nome
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL estado_insere(?,?,?)");
            $com->bind_param(
                "sis", $this->sigla, $this->codibge, $this->nome
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function seleciona($valor = null)
    {
        $c = My::con();
        if ($valor == "" || !isset($valor) || is_null($valor)) {
            $r = $c->query('CALL estados_seleciona()');
        } else {
            $r = $c->query('CALL estados_fulltext_seleciona(' . $valor . ', ' . EMPRESA . ')');
        }
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }
}