<?php

namespace modelo;

use bd\Formatos;
use bd\My;

class Empresa {

    private $id;
    private $nome;
    private $cnpj;
    private $telefone;
    private $enderecos_id;
    private $ativo;
    private $cliente;
    private $numero;
    private $complemento;
    private $whatsapp;
    private $email;
    private $matriz_id;
    private $tipo;
    private $subdomain;
    private $celular;
    private $abreviacao;
    private $pastor_id;
    private $pastor;
    private $associacao_id;

    /**
     * Empresa constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL empresa_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->cnpj = $l["cnpj"];
                $this->telefone = $l["telefone"];
                $this->enderecos_id = $l["enderecos_id"];
                $this->ativo = $l["ativo"];
                $this->cliente = $l["cliente"];
                $this->numero = $l["numero"];
                $this->complemento = $l["complemento"];
                $this->whatsapp = $l["whatsapp"];
                $this->email = $l["email"];
                $this->matriz_id = $l["matriz_id"];
                $this->tipo = $l["tipo"];
                $this->subdomain = $l["subdomain"];
                $this->celular = $l["celular"];
                $this->abreviacao = $l["abreviacao"];
                $this->pastor_id = $l["pastor_id"];
                $this->pastor = $l["pastor"];
                $this->associacao_id = $l["associacao_id"];
            }
            $c->next_result();
        }
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCnpj() {
        return Formatos::cnpjApp($this->cnpj);
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj) {
        $this->cnpj = Formatos::cnpjBd($cnpj);
    }

    /**
     * @return mixed
     */
    public function getTelefone() {
        return Formatos::telefoneApp($this->telefone);
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone) {
        $this->telefone = \bd\Formatos::telefoneBd($telefone);
    }

    /**
     * @return mixed
     */
    public function getCelular() {
        return Formatos::telefoneApp($this->celular);
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular) {
        $this->celular = Formatos::telefoneBd($celular);
    }

    /**
     * @return mixed
     */
    public function getEndereco() {
        return $this->enderecos_id;
    }

    /**
     * @param mixed $endereco_id
     */
    public function setEndereco($endereco_id) {
        $this->enderecos_id = $endereco_id;
    }

    /**
     * @return mixed
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero) {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getComplemento() {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    /**
     * @return mixed
     */
    public function getCliente() {
        return $this->cliente;
    }

    /**
     * @param mixed cliente
     */
    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getWhatsapp() {
        return $this->whatsapp;
    }

    /**
     * @param mixed $whatsapp
     */
    public function setWhatsapp($whatsapp) {
        $this->whatsapp = $whatsapp;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return \bd\Formatos::email($this->email);
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = \bd\Formatos::email($email);
    }

    /**
     * @return mixed
     */
    public function getMatrizId() {
        return $this->matriz_id;
    }

    /**
     * @param mixed $matriz_id
     */
    public function setMatrizId($matriz_id) {
        $this->matriz_id = $matriz_id;
    }

    /**
     * @return mixed
     */
    public function getAssociacaoId() {
        return $this->associacao_id;
    }

    /**
     * @param mixed $associacao_id
     */
    public function setAssociacaoId($associacao_id) {
        $this->associacao_id = $associacao_id;
    }

    /**
     * @return mixed
     */
    public function getTipo() {
        return \bd\Formatos::inteiro($this->tipo);
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo) {
        $this->tipo = \bd\Formatos::inteiro($tipo);
    }

    /**
     * @return mixed
     */
    public function getSubdomain() {
        return $this->subdomain;
    }

    /**
     * @param mixed $subdomain
     */
    public function setSubdomain($subdomain) {
        $this->subdomain = $subdomain;
    }

    /**
     * @return mixed
     */
    public function getAbreviacao() {
        return $this->abreviacao;
    }

    /**
     * @param mixed $abreviacao
     */
    public function setAbreviacao($abreviacao) {
        $this->abreviacao = $abreviacao;
    }

    /**
     * @return mixed
     */
    public function getPastorId() {
        return $this->pastor_id;
    }

    /**
     * @param mixed $pastor_id
     */
    public function setPastorId($pastor_id) {
        $this->pastor_id = $pastor_id;
    }

    /**
     * @return mixed
     */
    public function getPastor() {
        return $this->pastor;
    }

    public function salva() {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }

        if (!$this->cnpj) {
            throw new \Exception("CNPJ obrigatório(a).");
        }

        if (!$this->telefone) {
            throw new \Exception("Telefone obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL empresa_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "iisssssssssssiiss", $this->id, $this->enderecos_id, $this->ativo, $this->cliente, $this->nome, $this->cnpj, $this->telefone, $this->whatsapp, $this->numero, $this->complemento, $this->celular, $this->abreviacao, $this->email, $this->matriz_id, $this->associacao_id, $this->tipo, $this->subdomain
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL empresa_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                    "issssssssssiiss", $this->enderecos_id, $this->cliente, $this->nome, $this->cnpj, $this->telefone, $this->whatsapp, $this->numero, $this->complemento, $this->celular, $this->abreviacao, $this->email, $this->matriz_id, $this->associacao_id, $this->tipo, $this->subdomain
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
        }
    }

    public static function listaIgrejas($ativo = 'S') {
        $c = My::con();
        $empresa = NULL;
//        $r = $c->query("CALL empresas_seleciona(NULL,'$ativo')");
        $com = $c->prepare("CALL empresas_seleciona(?,?)");
        $com->bind_param("is", $empresa, $ativo);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function seleciona($valor = null) {
        $c = My::con();
        $empresa = EMPRESA;
        if ($valor == "" || !isset($valor) || is_null($valor)) {
            $r = $c->query("CALL empresas_seleciona($empresa, NULL)");
        } else {
            $r = $c->query("CALL empresas_fulltext_seleciona($valor, $empresa)");
        }
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function igrejasAgenda($ativo, $associacao) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT T1.nome,
                             -- fn_remove_accents(SUBSTRING(T1.nome, 1, 1)) letra,
                             T1.telefone,
                             T1.celular,
                             T1.email,
                             T2.sigla estado,
                             e.cep,
                             e.logradouro,
                             T1.numero,
                             e.bairro,
                             e.localidade municipio,
                             T1.complemento,
                             a.sigla associacao,
                             (SELECT CONCAT(p.tratamento, \' \', p.nome) 
                                FROM pastores p
                                INNER JOIN assoc_empresas_pastores ep
                                        ON p.id = ep.pastor_id
                                WHERE ep.categoria = \'T\'
                                        AND empresa_id = T1.id
                                ORDER BY ep.dt_entrada DESC
                                LIMIT 1) pastor
                    FROM empresas T1
                    LEFT JOIN associacoes a
                        ON T1.associacao_id = a.id
                       AND T1.id = a.empresa_id 
                    LEFT JOIN enderecos e
                        ON T1.enderecos_id = e.id
                    LEFT JOIN estados T2
                        ON e.estado_id = T2.id
                    WHERE T1.ativo = IFNULL(?, T1.ativo)
                      AND IFNULL(T1.associacao_id,\'\') = IFNULL(?, IFNULL(T1.associacao_id,\'\'))
                    ORDER BY e.localidade, T1.nome';
            $com = $c->prepare($query);
            $com->bind_param("si", $ativo, $associacao);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
