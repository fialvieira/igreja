<?php

namespace modelo;

use bd\My;

class Cargo
{
    private $id;
    private $nome;
    private $descricao;
    private $abreviacao;
    private $tipo_comissao;
    private $user_id;
    private $departamentos;
    private $empresa_id;
    private $created;
    private $modified;
    private $ativo;

    /**
     * Cargo constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $c = My::con();
            $r = $c->query("CALL cargo_seleciona($id," . EMPRESA . ")");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->descricao = $l["descricao"];
                $this->abreviacao = $l["abreviacao"];
                $this->tipo_comissao = $l["tipo_comissao"];
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
    public function getAbreviacao()
    {
        return $this->abreviacao;
    }

    /**
     * @param mixed $abreviacao
     */
    public function setAbreviacao($abreviacao)
    {
        $this->abreviacao = $abreviacao;
    }

    /**
     * @return mixed
     */
    public function getTipoComissao()
    {
        return $this->tipo_comissao;
    }

    /**
     * @param mixed $tipo_comissao
     */
    public function setTipoComissao($tipo_comissao)
    {
        $this->tipo_comissao = $tipo_comissao;
    }

    /**
     * @return string
     */
    public function getDepartamentos()
    {
        return $this->departamentos;
    }

    /**
     * @param array $departamentos
     */
    public function setDepartamentos($departamentos)
    {
        $this->departamentos = $departamentos;
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

    public function alteraStatusAtivo()
    {
        try {
            $c = My::con();
            if (!$this->ativo && !$this->id) {
                throw new \Exception("Problemas com envio de parâmetro.");
            }
            $com = $c->prepare("CALL cargo_altera_status(?,?,?,?,?,?)");
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

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }
        if ($this->id) {
            $com = $c->prepare("CALL cargo_altera(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssiss",
                $this->id,
                $this->nome,
                $this->descricao,
                $this->abreviacao,
                $this->tipo_comissao,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL cargo_insere(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssssiiss",
                $this->nome,
                $this->descricao,
                $this->abreviacao,
                $this->tipo_comissao,
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

    public function excluiDepartamentos()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($this->id) {
                $com = $c->prepare("DELETE
                                      FROM assoc_departamentos_cargos
                                      WHERE empresa_id = ?
                                        AND cargo_id = ?");
                $com->bind_param(
                    "ii",
                    $empresa,
                    $this->id
                );
                $com->execute();
            }
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function salvaDepartamentos()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if ($this->id && !is_null($this->departamentos)) {
                $deps = explode(',', $this->departamentos);
                for ($i = 0; $i < count($deps); $i++) {
                    $com = $c->prepare("INSERT INTO assoc_departamentos_cargos (departamento_id,
                                                                                      cargo_id,
                                                                                      empresa_id,
                                                                                      user_id,
                                                                                      created,
                                                                                      modified)
                                                                              VALUES (?, ?, ?, ?, ?, ?)");
                    $com->bind_param(
                        "iiiiss",
                        $deps[$i],
                        $this->id,
                        $empresa,
                        $this->user_id,
                        $this->created,
                        $this->modified
                    );
                    $com->execute();
                }
            }
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function seleciona($ativo = null)
    {
        $c = My::con();
        if (!isset($ativo) || $ativo == "" || is_null($ativo)) {
            $ativo = "S";
        }
        $r = $c->query("CALL cargos_seleciona('$ativo'," . EMPRESA . ")");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public function getCargosDepartamentos()
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($this->id) {
            $com = $c->prepare('SELECT adc.*
                                            ,c.`nome` cargo
                                            ,d.`nome` departamento
                                      FROM assoc_departamentos_cargos adc
                                      INNER JOIN cargos c
                                        ON adc.`cargo_id` = c.`id`
                                      INNER JOIN departamentos d
                                       ON adc.`departamento_id` = d.`id`
                                      WHERE adc.empresa_id = ?
                                        AND adc.cargo_id = ?');
            $com->bind_param(
                "ii",
                $empresa,
                $this->id
            );
            $com->execute();
            $r = $com->get_result();
        }
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }
}