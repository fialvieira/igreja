<?php

namespace modelo;

use bd\My;

class Banco
{
    private $id;
    private $nome;
    private $numero;
    private $cnpj;

    /**
     * Banco constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL banco_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->numero = $l["numero"];
                $this->cnpj = $l["cnpj"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $número
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }

        if (!$this->numero) {
            throw new \Exception("Número obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL banco_altera(?,?,?,?)");
            $com->bind_param(
                "isss",
                $this->id,
                $this->nome,
                $this->numero,
                $this->cnpj
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL banco_insere(?,?,?)");
            $com->bind_param(
                "sss",
                $this->nome,
                $this->numero,
                $this->cnpj
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
        $r = $c->query("CALL bancos_seleciona()");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function selecionaPorCnpj($cnpj)
    {
        try {
            $c = My::con();
            $com = $c->prepare("SELECT COUNT(*) TOTAL
                                      FROM bancos
                                      WHERE cnpj = ?");
            $com->bind_param(
                "s",
                $cnpj
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $retorno = $l['TOTAL'];
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function selecionaPorNumero($numero)
    {
        try {
            $c = My::con();
            $com = $c->prepare("SELECT COUNT(*) TOTAL
                                     FROM bancos
                                     WHERE numero = ?");
            $com->bind_param(
                "s",
                $numero
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $retorno = $l['TOTAL'];
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}