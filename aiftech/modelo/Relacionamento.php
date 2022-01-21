<?php

namespace modelo;

use bd\My;

class Relacionamento
{
    private $id;
    private $membro_id;
    private $tiporelacionamento_id;
    private $membro2_id;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Relacionamento constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL relacionamento_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->membro_id = $l["membro_id"];
                $this->tiporelacionamento_id = $l["tiporelacionamento_id"];
                $this->membro2_id = $l["membro2_id"];
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
    public function getMembroId()
    {
        return \bd\Formatos::inteiro($this->membro_id);
    }

    /**
     * @param mixed $membro_id
     */
    public function setMembroId($membro_id)
    {
        $this->membro_id = \bd\Formatos::inteiro($membro_id);
    }

    /**
     * @return mixed
     */
    public function getTiporelacionamentoId()
    {
        return \bd\Formatos::inteiro($this->tiporelacionamento_id);
    }

    /**
     * @param mixed $tiporelacionamento_id
     */
    public function setTiporelacionamentoId($tiporelacionamento_id)
    {
        $this->tiporelacionamento_id = \bd\Formatos::inteiro($tiporelacionamento_id);
    }

    /**
     * @return mixed
     */
    public function getMembro2Id()
    {
        return \bd\Formatos::inteiro($this->membro2_id);
    }

    /**
     * @param mixed $membro2_id
     */
    public function setMembro2Id($membro2_id)
    {
        $this->membro2_id = \bd\Formatos::inteiro($membro2_id);
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

    public static function getIdPorParametros($membro_id, $membro2_id, $tipo_relacionamento)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $com = $c->prepare("SELECT id
                                      FROM relacionamentos
                                      WHERE membro_id = ?
                                        AND CASE
                                              WHEN ? = 1 THEN (tiporelacionamento_id = 1 OR tiporelacionamento_id = 2)
                                              ELSE tiporelacionamento_id = ?
                                            END
                                        AND membro2_id = ?
                                        AND empresa_id = ?");
            $com->bind_param(
                "iiiii",
                $membro_id,
                $tipo_relacionamento,
                $tipo_relacionamento,
                $membro2_id,
                $empresa
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l['id'];
        } catch (\Exception $e) {
            throw new \Exception('Erro ao procurar por id de membro filho(a)');
        }
    }

    public function exclui()
    {
        try {
            $c = My::con();
            if ($this->id) {
                $com = $c->prepare("CALL relacionamento_exclui(?,?)");
                $com->bind_param(
                    "ii",
                    $this->id,
                    $this->empresa_id
                );
                $com->execute();
            }
        } catch (\Exception $e) {
            throw new \Exception('Erro ao excluir parentesco');
        }
    }

    public function salva()
    {
        try {
            $c = My::con();

            if ($this->id) {
                $com = $c->prepare("CALL relacionamento_altera(?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "iiiiiiss",
                    $this->id,
                    $this->membro_id,
                    $this->tiporelacionamento_id,
                    $this->membro2_id,
                    $this->empresa_id,
                    $this->user_id,
                    $this->created,
                    $this->modified
                );
                $com->execute();
            } else {
                $com = $c->prepare("CALL relacionamento_insere(?,?,?,?,?,?,?)");
                $com->bind_param(
                    "iiiiiss",
                    $this->membro_id,
                    $this->tiporelacionamento_id,
                    $this->membro2_id,
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
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function seleciona($membro_id)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $query = 'SELECT r.id
                        ,tr.id tipo_relacionamento_id
                        ,tr.`descricao`
                        ,r.`membro_id`
                        ,m.`nome` nome_um
                        ,r.`membro2_id`
                        ,m2.`nome` nome_dois
                FROM relacionamentos r
                INNER JOIN tipo_relacionamentos tr
                  ON r.`tiporelacionamento_id` = tr.`id`
                LEFT JOIN membros m
                  ON r.`membro_id` = m.`id`
                LEFT JOIN membros m2
                  ON r.`membro2_id` = m2.`id`
                WHERE r.`empresa_id` = ?
                  AND membro_id = ?';
        $com = $c->prepare($query);
        $com->bind_param('ii', $empresa, $membro_id);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }
}
