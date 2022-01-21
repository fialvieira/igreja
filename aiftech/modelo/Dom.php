<?php

namespace modelo;

use bd\My;

class Dom
{
    private $id;
    private $nome;
    private $observacoes;
    private $user_id;
    private $ativo;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * Dom constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL dom_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->observacoes = $l["observacoes"];
                $this->ativo = $l["ativo"];
                $this->user_id = $l["user_id"];
                $this->empresa_id = $l["empresa_id"];
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
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
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
        try{
            $c = My::con();
            if (!$this->ativo && !$this->id) {
                throw new \Exception("Problemas com envio de parâmetro.");
            }
            $com = $c->prepare("CALL dom_altera_status(?,?,?,?,?,?)");
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
        }catch (\Exception $e){
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
            $com = $c->prepare("CALL dom_altera(?,?,?,?,?,?,?)");
            $com->bind_param(
                "issiiss",
                $this->id,
                $this->nome,
                $this->observacoes,
                $this->user_id,
                $this->empresa_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL dom_insere(?,?,?,?,?,?)");
            $com->bind_param(
                "ssiiss",
                $this->nome,
                $this->observacoes,
                $this->user_id,
                $this->empresa_id,
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

    public static function selecionaPorUsuarioEmpresa($user_id, $dom_id = null)
    {
        $c = My::con();
        $emp = EMPRESA;
        $retorno = [];
        if ($dom_id === '' || !isset($dom_id) || is_null($dom_id)) {
            $query = 'SELECT pd.*,
                           d.`nome`,
                           d.`observacoes`
                      FROM pessoa_dons pd
                      LEFT JOIN dons d
                          ON pd.`dom_id` = d.`id`
                         AND pd.`empresa_id` = d.`empresa_id`
                      WHERE pd.`membro_id` = ?
                        AND pd.`empresa_id` = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii",
                $user_id,
                $emp
            );
            $com->execute();
            $r = $com->get_result();
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
        } else {
            $query = 'SELECT pd.*,
                           d.`nome`,
                           d.`observacoes`
                    FROM pessoa_dons pd
                    LEFT JOIN dons d
                        ON pd.`dom_id` = d.`id`
                       AND pd.`empresa_id` = d.`empresa_id`
                    WHERE pd.`membro_id` = ?
                      AND pd.`empresa_id` = ?
                      AND pd.`dom_id` = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "iii",
                $user_id,
                $emp,
                $dom_id
            );
            $com->execute();
            $r = $com->get_result();
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
        }
        return $retorno;
    }

    public static function seleciona($ativo = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $vativo = (is_null($ativo) || $ativo == '' || !isset($ativo)) ? null : $ativo;
        $r = $c->query("CALL dons_seleciona($empresa, '$vativo')");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    /**Função para verificar se já existe registro de um dom para um membro de uma empresa.
     * @param int , int, int
     *
     * @return integer
     */
    public static function temRegistroPessoasDons($membro_id, $sdom_id, $empresa)
    {
        $c = My::con();
        $query = 'SELECT COUNT(*) TOTAL
                  FROM pessoa_dons
                  WHERE membro_id = ?
                    AND dom_id = ?
                    AND empresa_id = ?';
        $com = $c->prepare($query);
        $com->bind_param(
            "iii",
            $membro_id,
            $sdom_id,
            $empresa
        );
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();
        return $l['TOTAL'];
    }

    /**Funç para excluir um dom de uma pessoa
     * @param $membro_id
     * @param $dom_id
     * @param $empresa
     *
     * */
    public static function excluiPessoaDom($membro_id, $dom_id, $empresa)
    {
        try {
            $c = My::con();
            $query = 'DELETE
                     FROM pessoa_dons
                     WHERE membro_id = ?
                      AND dom_id = ?
                      AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "iii",
                $membro_id,
                $dom_id,
                $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**Funç para excluir dons de uma pessoa
     * @param $membro_id
     * @param $empresa
     *
     * */
    public static function excluiPessoaDons($membro_id, $empresa)
    {
        try {
            $c = My::con();
            $query = 'DELETE
                      FROM pessoa_dons
                      WHERE membro_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii",
                $membro_id,
                $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public static function gravaPessoaDons($membro_id, $dom_id, $empresa, $user_id, $created, $modified)
    {
        try {
            $c = My::con();
            $query = "INSERT INTO pessoa_dons (
                                                  dom_id,
                                                  membro_id,
                                                  empresa_id,
                                                  user_id,
                                                  created,
                                                  modified
                                                )
                                                VALUES
                                                  (
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?)";
            $com = $c->prepare($query);
            $com->bind_param(
                "iiiiss",
                $dom_id,
                $membro_id,
                $empresa,
                $user_id,
                $created,
                $modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            dd($exc->getMessage());
        }
    }
}