<?php

namespace modelo;

use bd\Formatos;
use bd\My;

class MovimentacaoMembro
{
    const TIPO_MM = [
        'E' => 'ENTRADA',
        'A' => 'AGUARDANDO',
        'S' => 'SAÍDA',
        'D' => 'DOCUMENTO',
        'F' => 'FREQUÊNCIA'
    ];

    private $id;
    private $membro_id;
    private $empresa_id;
    private $ata_id;
    private $carta_id;
    private $data_carta_recebimento;
    private $carta_recebimento_path;
    private $tipo_movimentacao_membro_id;
    private $observacao;
    private $user_id;
    private $created;
    private $modified;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("SELECT *
                                   FROM movimentacao_membros
                                   WHERE id = $id
                                     AND empresa_id = $empresa");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->membro_id = $l['membro_id'];
                $this->empresa_id = $l["empresa_id"];
                $this->ata_id = $l['ata_id'];
                $this->carta_id = $l['carta_id'];
                $this->data_carta_recebimento = $l['data_carta_recebimento'];
                $this->carta_recebimento_path = $l['carta_recebimento_path'];
                $this->tipo_movimentacao_membro_id = $l['tipo_movimentacao_membro_id'];
                $this->observacao = $l["observacao"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getMembroId()
    {
        return $this->membro_id;
    }

    /**
     * @param mixed $membro_id
     */
    public function setMembroId($membro_id)
    {
        $this->membro_id = Formatos::inteiro($membro_id);
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = Formatos::inteiro($empresa_id);
    }

    /**
     * @return mixed
     */
    public function getAtaId()
    {
        return $this->ata_id;
    }

    /**
     * @param mixed $ata_id
     */
    public function setAtaId($ata_id)
    {
        $this->ata_id = Formatos::inteiro($ata_id);
    }

    /**
     * @return mixed
     */
    public function getCartaId()
    {
        return $this->carta_id;
    }

    /**
     * @param mixed $carta_id
     */
    public function setCartaId($carta_id)
    {
        $this->carta_id = Formatos::inteiro($carta_id);
    }

    /**
     * @return mixed
     */
    public function getDataCartaRecebimento()
    {
        return Formatos::dataApp(($this->data_carta_recebimento != '0000-00-00') ? $this->data_carta_recebimento : '');
    }

    /**
     * @param mixed $data_carta_recebimento
     */
    public function setDataCartaRecebimento($data_carta_recebimento)
    {
        $this->data_carta_recebimento = Formatos::dataBd($data_carta_recebimento);
    }

    /**
     * @return mixed
     */
    public function getCartaRecebimentoPath()
    {
        return $this->carta_recebimento_path;
    }

    /**
     * @param mixed $carta_recebimento_path
     */
    public function setCartaRecebimentoPath($carta_recebimento_path)
    {
        $this->carta_recebimento_path = $carta_recebimento_path;
    }

    /**
     * @return mixed
     */
    public function getTipoMovimentacaoMembroId()
    {
        return $this->tipo_movimentacao_membro_id;
    }

    /**
     * @param mixed $tipo_movimentacao_membro_id
     */
    public function setTipoMovimentacaoMembroId($tipo_movimentacao_membro_id)
    {
        $this->tipo_movimentacao_membro_id = Formatos::inteiro($tipo_movimentacao_membro_id);
    }

    /**
     * @return mixed
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param mixed $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = Formatos::inteiro($user_id);
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return Formatos::dataApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return Formatos::dataApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    public function salva()
    {
        try {
            $c = My::con();
            if ($this->id) {
                $com = $c->prepare("CALL movimentacao_membro_altera(?,?,?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "iiiiissisiss",
                    $this->id,
                    $this->membro_id,
                    $this->empresa_id,
                    $this->ata_id,
                    $this->carta_id,
                    $this->data_carta_recebimento,
                    $this->carta_recebimento_path,
                    $this->tipo_movimentacao_membro_id,
                    $this->observacao,
                    $this->user_id,
                    $this->created,
                    $this->modified
                );
                $com->execute();
            } else {
                $com = $c->prepare("CALL movimentacao_membro_insere(?,?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "iiiissisiss",
                    $this->membro_id,
                    $this->empresa_id,
                    $this->ata_id,
                    $this->carta_id,
                    $this->data_carta_recebimento,
                    $this->carta_recebimento_path,
                    $this->tipo_movimentacao_membro_id,
                    $this->observacao,
                    $this->user_id,
                    $this->created,
                    $this->modified
                );
                $com->execute();
            }
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->id = $l["id"];
            $c->next_result();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function exclui()
    {
        try {
            $c = My::con();
            if ($this->id) {
                $com = $c->prepare("DELETE
                                           FROM movimentacao_membros
                                           WHERE id = ?
                                             AND empresa_id = ?");
                $com->bind_param(
                    "ii",
                    $this->id,
                    $this->empresa_id
                );
                $com->execute();
            } else {
                throw new \Exception('Não há registro para excluir');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function listaTiposMovimentacao()
    {
        $c = My::con();
        $query = 'SELECT *
                  FROM tipo_movimentacao_membro
                  ORDER BY nome';
        $r = $c->query($query);
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function listaMovimentacaoMembros($membro_id)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $query = "CALL movimentacao_membros_seleciona($membro_id, $empresa)";
        $r = $c->query($query);
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    /**
     * @param $membro_id
     * @return array
     * @throws \Exception
     */
    public static function relatorioMovimentacaoMembros(
        $membro_id = null,
        $tipo_mm = null,
        $ata_id = null,
        $data_inicio = null,
        $data_fim = null
    )
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $membro_id = is_null($membro_id) ? gettype($membro_id) : $membro_id;
            $tipo_mm = is_null($tipo_mm) ? gettype($tipo_mm) : $tipo_mm;
            $ata_id = is_null($ata_id) ? gettype($ata_id) : $ata_id;
            $data_inicio = is_null($data_inicio) ? gettype($data_inicio) : '\'' . Formatos::dataBd($data_inicio) . '\'';
            $data_fim = is_null($data_fim) ? gettype($data_fim) : '\'' . Formatos::dataBd($data_fim) . '\'';
            $query = "CALL movimentacao_membros_rel($empresa, $membro_id, $tipo_mm, $ata_id, $data_inicio, $data_fim)";
            $r = $c->query($query);
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            $c->next_result();
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}