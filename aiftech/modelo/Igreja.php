<?php
/**
 * Created by PhpStorm.
 * User: Filipe
 * Date: 20/10/2017
 * Time: 01:41
 */

namespace modelo;

use bd\My;

class Igreja
{
    private $id;
    private $nome;
    private $abreviacao;
    private $endereco;
    private $cidade;
    private $uf;
    private $cep;
    private $celular;
    private $whats;
    private $telefone;
    private $email;

    /**
     * Igreja constructor.
     */
    public function __construct($id = null)
    {
        if(!is_null($id)){
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL igreja_seleciona($id)");
            $l = $r->fetch_assoc();
            if($l){
                $this->id = $l["id"];
                $this->nome = $l["nome"];
                $this->abreviacao = $l["abreviacao"];
                $this->endereco = $l["endereco"];
                $this->cidade = $l["cidade"];
                $this->uf = $l["uf"];
                $this->cep = $l["cep"];
                $this->celular = $l["celular"];
                $this->whats = $l["whatsapp"];
                $this->telefone = $l["telefone"];
                $this->email = $l["email"];
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
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getAbreviacao()
    {
        return $this->abreviacao;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @return mixed
     */
    public function getWhats()
    {
        return $this->whats;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $abreviacao
     */
    public function setAbreviacao($abreviacao)
    {
        $this->abreviacao = $abreviacao;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @param mixed $whats
     */
    public function setWhats($whats)
    {
        $this->whats = $whats;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public static function seleciona()
    {
        $c = My::con();
        $r = $c->query("CALL igrejas_seleciona()");
        $retorno = [];
        while ($l = $r->fetch_assoc()){
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }
}