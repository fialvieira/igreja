<?php

namespace modelo;

use bd\My;

class Local
{
    private $id;
    private $nome;
    private $sede;
    private $empresas_id;
    private $user_id;
    private $created;
    private $modified;
    private $ativo;

    /**
     * Local constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL local_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->sede = $l["sede"];
                $this->empresas_id = $l["empresa_id"];
                $this->ativo = $l["ativo"];
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
    public function getid()
    {
        return \bd\Formatos::inteiro($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setid($id)
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
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * @param mixed $sede
     */
    public function setSede($sede)
    {
        $this->sede = $sede;
    }

    /**
     * @return mixed
     */
    public function getEmpresasId()
    {
        return \bd\Formatos::inteiro($this->empresas_id);
    }

    /**
     * @param mixed $empresas_id
     */
    public function setEmpresasId($empresas_id)
    {
        $this->empresas_id = \bd\Formatos::inteiro($empresas_id);
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

    public function alteraStatusAtivo()
    {
        $c = My::con();
        if (!$this->ativo) {
            throw new \Exception("Problemas com envio de parâmetro.");
        }
        $com = $c->prepare("CALL local_altera_status(?,?,?,?,?,?)");
        $com->bind_param(
            "iisiss",
            $this->id,
            $this->empresas_id,
            $this->ativo,
            $this->user_id,
            $this->created,
            $this->modified
        );
        $com->execute();
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->sede) {
            throw new \Exception("Sede obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL local_altera(?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issisiss",
                $this->id,
                $this->nome,
                $this->sede,
                $this->empresas_id,
                $this->ativo,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL local_insere(?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssisiss",
                $this->nome,
                $this->sede,
                $this->empresas_id,
                $this->ativo,
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

    public static function seleciona($ativo = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($ativo == "" || !isset($ativo) || is_null($ativo)) {
            $ativo = "S";
        }
        $r = $c->query("CALL locais_seleciona('$ativo', $empresa)");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function getLocaisPorParametros($ativo, $eh_sede, $esta_na_sede)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'SELECT T1.*
                      FROM `local` T1
                      WHERE T1.empresa_id = ?
                        AND T1.`ativo` = IFNULL(?, T1.`ativo`)
                        AND T1.`e_sede` = IFNULL(?, T1.`e_sede`)
                        AND T1.`sede` = IFNULL(?, T1.`sede`)
                      ORDER BY T1.nome';
            $com = $c->prepare($query);
            $com->bind_param("isss", $empresa, $ativo, $eh_sede, $esta_na_sede);
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