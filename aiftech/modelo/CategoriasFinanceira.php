<?php

namespace modelo;

use bd\My;

class CategoriasFinanceira
{

    private $id;
    private $numero;
    private $nome;
    private $descricao;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $tipo;
    private $ativo;
    private $categoria_mae;
    private $responsavel;

    /**
     * CategoriasFinanceira constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL categoria_financeira_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $l["id"];
                $this->nome = $l["nome"];
                $this->descricao = $l["descricao"];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->tipo = $l["tipo"];
                $this->ativo = $l["ativo"];
                $this->categoria_mae = $l["categoria_mae"];
                $this->responsavel = $l["responsavel"];
                $this->numero = $l["num"];
            }
            $c->next_result();
        }
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
    public function getCategoriaMae()
    {
        return $this->categoria_mae;
    }

    /**
     * @param mixed $categoria_mae
     */
    public function setCategoriaMae($categoria_mae)
    {
        $this->categoria_mae = $categoria_mae;
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
     * @return string
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * @param string $responsavel
     */
    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;
    }

    public function alteraStatusAtivo()
    {
        try {
            if ($this->id) {
                $c = My::con();
                $query = 'UPDATE categorias_financeira
                          SET ativo = ?
                             ,user_id = ?
                             ,modified = ?
                          WHERE id = ?
                            AND empresa_id = ?';
                $com = $c->prepare($query);
                $com->bind_param(
                    "sisii", $this->ativo, $this->user_id, $this->modified, $this->id, $this->empresa_id
                );
                $com->execute();
            } else {
                throw new \Exception('Não é possível mudar o status desta conta');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function gravaContasFinanceira($conta_financeira_id, $categoria_financeira_id, $user_id, $created, $modified)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "INSERT INTO assoc_contas_categorias_financeira (contas_financeira_id, categorias_financeira_id, empresa_id, user_id, created, modified)
													   VALUES (?, ?, ?, ?, ?, ?)";
            $com = $c->prepare($query);
            $com->bind_param(
                "iiiiss", $conta_financeira_id, $categoria_financeira_id, $empresa, $user_id, $created, $modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            dd($exc->getMessage());
        }
    }

    public static function excluiContasFinanceiras($id)
    {
        try {
            $empresa = EMPRESA;
            $c = My::con();
            $query = 'DELETE
                      FROM assoc_contas_categorias_financeira
                      WHERE categorias_financeira_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii", $id, $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function salva()
    {
        try {
            $c = My::con();
            if (!$this->nome) {
                throw new \Exception("Nome obrigatório.");
            }

            if (!$this->numero) {
                throw new \Exception("Número obrigatório.");
            }

            if (!$this->tipo) {
                throw new \Exception("Tipo obrigatório.");
            }

            if ($this->id) {
                $com = $c->prepare("CALL categorias_financeira_altera(?,?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "issssiiisss", $this->id, $this->numero, $this->nome, $this->descricao, $this->tipo, $this->categoria_mae,
                    $this->empresa_id, $this->user_id, $this->created, $this->modified, $this->responsavel
                );
                $com->execute();
            } else {
                $com = $c->prepare("CALL categorias_financeira_insere(?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                    "ssssiiisss", $this->numero, $this->nome, $this->descricao, $this->tipo, $this->categoria_mae,
                    $this->empresa_id, $this->user_id, $this->created, $this->modified, $this->responsavel
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

    public static function selecionaTodos()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $r = $c->query("CALL categorias_financeira_seleciona($empresa, NULL)");
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function categoriasRaizes()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("SELECT id, num, nome
                                   FROM categorias_financeira
                                   WHERE categoria_mae IS NULL
                                     AND empresa_id = $empresa");
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function verificaCategoriaMae($id)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("SELECT COUNT(*) TOTAL
                                  FROM categorias_financeira
                                  WHERE categoria_mae = $id
                                    AND ativo = 'S'
                                    AND empresa_id = $empresa");
            $l = $r->fetch_assoc();
            $retorno = $l['TOTAL'];
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function verificaCategoriaAtiva($id)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $r = $c->query("SELECT ativo
                                   FROM categorias_financeira
                                   WHERE id = $id
                                     AND empresa_id = $empresa;");
            $l = $r->fetch_assoc();
            $retorno = $l['ativo'];
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getCategoriasMae($ativo = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($ativo) || !isset($ativo) || $ativo == '') {
                $ativo = null;
            }
            $r = $c->query("SELECT cf.*, fn_sort_number(cf.num) numero_categoria
                                  FROM categorias_financeira cf
                                  WHERE empresa_id = $empresa
                                    AND cf.`ativo` = IFNULL('$ativo', cf.`ativo`)
                                  ORDER BY numero_categoria");
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getCategoriasFilhas($ativo = null, $tipo = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $ativo = (is_null($ativo) || !isset($ativo) || $ativo == '') ? null : $ativo;
            $tipo = (is_null($ativo) || !isset($ativo) || $ativo == '') ? null : $tipo;
            $com = $c->prepare("CALL categorias_financeira_get_filhas(?,?,?)");
            $com->bind_param(
                "iss", $empresa, $ativo, $tipo
            );
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

    public function getContasFinanceiras()
    {
        try {
            if ($this->id) {
                $c = My::con();
                $empresa = EMPRESA;
                $query = "SELECT cfi.*
                                ,cof.`id` conta_id
                                ,cof.`nome` conta_nome
                                ,cof.`agencia`
                                ,cof.`numero`
                                ,cof.`tipo_conta`
                                ,ban.`nome` banco_nome
                          FROM categorias_financeira cfi
                          LEFT JOIN assoc_contas_categorias_financeira ccf
                            ON cfi.`id` = ccf.`categorias_financeira_id`
                           AND cfi.`empresa_id` = ccf.`empresa_id`
                          LEFT JOIN contas_financeira cof
                            ON ccf.`contas_financeira_id` = cof.`id`
                           AND ccf.`empresa_id` = cof.`empresa_id`
                          LEFT JOIN bancos ban
                            ON cof.`banco_id` = ban.`id`
                          WHERE cfi.`empresa_id` = ?
                            AND cfi.`id` = ?
                            AND cof.`ativo` = 'S'";
                $com = $c->prepare($query);
                $com->bind_param(
                    "ii", $empresa, $this->id
                );
                $com->execute();
                $r = $com->get_result();
                $retorno = [];
                while ($l = $r->fetch_assoc()) {
                    $retorno[] = $l;
                }
                return $retorno;
            } else {
                throw new \Exception('Deve existir conta');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getLancamentosCategoriasMae($data, $ativo = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($ativo) || !isset($ativo) || $ativo = '') {
                $ativo = null;
            }
            $data = \bd\Formatos::dataBd($data);

            $com = $c->prepare("CALL get_lancamentos_categorias_mae(?,?,?)");
            $com->bind_param(
                "iss", $empresa, $ativo, $data
            );
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
