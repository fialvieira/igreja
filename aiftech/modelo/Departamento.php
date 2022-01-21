<?php

namespace modelo;

use bd\My;

class Departamento
{
    private $id;
    private $nome;
    private $abreviacao;
    private $eleicao;
    private $interesse;
    private $ativo;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $tipo;

    /**
     * Departamento constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL departamento_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->abreviacao = $l["abreviacao"];
                $this->eleicao = $l["eleicao"];
                $this->interesse = $l["interesse"];
                $this->tipo = $l["tipo"];
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
    public function getEleicao()
    {
        return $this->eleicao;
    }

    /**
     * @param mixed $eleicao
     */
    public function setEleicao($eleicao)
    {
        $this->eleicao = $eleicao;
    }

    /**
     * @return mixed
     */
    public function getInteresse()
    {
        return $this->interesse;
    }

    /**
     * @param mixed $interesse
     */
    public function setInteresse($interesse)
    {
        $this->interesse = $interesse;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
            $com = $c->prepare("CALL departamento_altera_status(?,?,?,?,?,?)");
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
            throw new \Exception("Nome obrigatório.");
        }

        if ($this->id) {
            $com = $c->prepare("CALL departamento_altera(?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "isssssiiss",
                $this->id,
                $this->nome,
                $this->abreviacao,
                $this->eleicao,
                $this->interesse,
                $this->tipo,
                $this->empresa_id,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL departamento_insere(?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "sssssiiss",
                $this->nome,
                $this->abreviacao,
                $this->eleicao,
                $this->interesse,
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

    public static function selecionaPorCargo($cargo_id)
    {
        if(!$cargo_id || !isset($cargo_id) || is_null($cargo_id) || $cargo_id == ''){
            throw new \Exception('Cargo não selecionado');
        }
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("SELECT dep.id
                                        ,dep.nome
                                  FROM departamentos dep
                                  INNER JOIN assoc_departamentos_cargos adc
                                      ON dep.id = adc.departamento_id
                                     AND dep.empresa_id = adc.empresa_id
                                  INNER JOIN cargos car
                                      ON adc.cargo_id = car.id
                                     AND adc.empresa_id = car.empresa_id
                                  WHERE adc.cargo_id = ?
                                    AND adc.empresa_id = ?");
        $com->bind_param(
            "ii",
            $cargo_id,
            $empresa
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function seleciona($ativo = null, $eleicao = null, $interesse = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $vativo = (is_null($ativo) || $ativo == '' || !isset($ativo)) ? null : $ativo;
        $veleicao = (is_null($eleicao) || $eleicao == '' || !isset($eleicao)) ? null : $eleicao;
        $vinteresse = (is_null($interesse) || $interesse == '' || !isset($interesse)) ? null : $interesse;
        $com = $c->prepare("CALL departamentos_seleciona(?,?,?,?)");
        $com->bind_param(
            "isss",
            $empresa,
            $vativo,
            $veleicao,
            $vinteresse
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

    public function exclui()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("CALL departamento_exclui($this->id, $empresa)");
        $existe = self::existeDepartamento($this->id);
        if (!$existe) {
            $ret = true;
        } else {
            $ret = false;
        }
        return $ret;
    }

    public static function existeDepartamento($id)
    {
        $c = My::con();
        $r = $c->query("CALL departamento_seleciona($id)");
        $l = $r->fetch_assoc();
        $c->next_result();
        if (count($l) < 1) {
            return false;
        } else {
            return true;
        }
    }
}