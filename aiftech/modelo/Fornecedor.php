<?php

namespace modelo;

use bd\My;

class Fornecedor
{
    private $id;
    private $nome_fantasia;
    private $razao_social;
    private $cnpj;
    private $email;
    private $telefone;
    private $telefone2;
    private $endereco_id;
    private $complemento;
    private $numero;
    private $tipo;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $ativo;

    /**
     * Fornecedor constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $c = My::con();
            $r = $c->query("CALL fornecedor_seleciona($id," . EMPRESA . ")");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome_fantasia = $l["nome_fantasia"];
                $this->razao_social = $l["razao_social"];
                $this->cnpj = $l["cnpj"];
                $this->email = $l["email"];
                $this->telefone = $l["telefone"];
                $this->telefone2 = $l["telefone2"];
                $this->endereco_id = $l["endereco_id"];
                $this->complemento = $l["enderecos_complemento"];
                $this->numero = $l["enderecos_numero"];
                $this->tipo = $l["tipo"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->ativo = $l["ativo"];
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
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNomeFantasia()
    {
        return $this->nome_fantasia;
    }

    /**
     * @param mixed $nome_fantasia
     */
    public function setNomeFantasia($nome_fantasia)
    {
        $this->nome_fantasia = $nome_fantasia;
    }

    /**
     * @return mixed
     */
    public function getRazaoSocial()
    {
        return $this->razao_social;
    }

    /**
     * @param mixed $razao_social
     */
    public function setRazaoSocial($razao_social)
    {
        $this->razao_social = $razao_social;
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return \bd\Formatos::cnpjApp($this->cnpj);
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = \bd\Formatos::cnpjBd($cnpj);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return \bd\Formatos::email($this->email);
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = \bd\Formatos::email($email);
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return \bd\Formatos::telefoneApp($this->telefone);
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = \bd\Formatos::telefoneBd($telefone);
    }

    /**
     * @return mixed
     */
    public function getTelefone2()
    {
        return \bd\Formatos::telefoneApp($this->telefone2);
    }

    /**
     * @param mixed $telefone2
     */
    public function setTelefone2($telefone2)
    {
        $this->telefone2 = \bd\Formatos::telefoneBd($telefone2);
    }

    /**
     * @return mixed
     */
    public function getEnderecosId()
    {
        return \bd\Formatos::inteiro($this->endereco_id);
    }

    /**
     * @param mixed $enderecos_id
     */
    public function setEnderecosId($enderecos_id)
    {
        $this->endereco_id = \bd\Formatos::inteiro($enderecos_id);
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
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return \bd\Formatos::inteiro($this->tipo);
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = \bd\Formatos::inteiro($tipo);
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

    public function salva()
    {
        $c = My::con();
        if (!$this->nome_fantasia) {
            throw new \Exception("Nome Fantasia obrigatório(a).");
        }

        if (!$this->razao_social) {
            throw new \Exception("Razao Social obrigatório(a).");
        }

        if (!$this->cnpj) {
            throw new \Exception("Cnpj obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL fornecedor_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssssissisiiss",
                $this->id,
                $this->nome_fantasia,
                $this->razao_social,
                $this->cnpj,
                $this->email,
                $this->telefone,
                $this->telefone2,
                $this->endereco_id,
                $this->numero,
                $this->complemento,
                $this->tipo,
                $this->ativo,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {

            $com = $c->prepare("CALL fornecedor_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssssssissiiiss",
                $this->nome_fantasia,
                $this->razao_social,
                $this->cnpj,
                $this->email,
                $this->telefone,
                $this->telefone2,
                $this->endereco_id,
                $this->numero,
                $this->complemento,
                $this->tipo,
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

    public function alteraStatusAtivo()
    {
        $c = My::con();
        if (!$this->ativo) {
            throw new \Exception("Problemas com envio de parâmetro.");
        }
        $com = $c->prepare("CALL fornecedores_altera_status(?,?,?,?,?,?)");
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
    }

    public static function seleciona($ativo = null)
    {
        $c = My::con();
        if (!isset($ativo) || $ativo == "" || is_null($ativo)) {
            $ativo = "S";
        }
        $r = $c->query("CALL fornecedores_seleciona('$ativo'," . EMPRESA . ")");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }
}