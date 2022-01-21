<?php

namespace modelo;

use bd\My;
use bd\Formatos;
use Exception;

class CompraOrcamento {

    private $compra_id;
    private $data_orcamento;
    private $orcamento_path;
    private $fornecedor_id;
    private $nome_arquivo;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * CompraItem constructor.
     * @param int $compra_id
     * @param int $fornecedor_id
     * @throws Exception
     */
    public function __construct($compra_id = null, $fornecedor_id = null) {
        try {
            if (!is_null($compra_id) && !is_null($fornecedor_id)) {
                $c = My::con();
                $empresa = EMPRESA;
                $com = $c->prepare("SELECT *
                                           FROM compras_orcamentos
                                           WHERE fornecedores_id = ?
                                             AND compras_id = ?
                                             AND empresa_id = ?");
                $com->bind_param(
                    "iii", $fornecedor_id,$compra_id, $empresa);
                $com->execute();
                $r = $com->get_result();
                $l = $r->fetch_assoc();
                if ($l) {
                    $this->compra_id = $compra_id;
                    $this->fornecedor_id = $fornecedor_id;
                    $this->orcamento_path = $l["orcamento_path"];
                    $this->nome_arquivo = $l["nome_arquivo"];
                    $this->data_orcamento = $l["data_orcamento"];
                    $this->user_id = $l["user_id"];
                    $this->empresa_id = $l["empresa_id"];
                    $this->created = $l["created"];
                    $this->modified = $l["modified"];
                }
//                $c->next_result();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return int|null
     */
    public function getCompraId() {
        return $this->compra_id;
    }

    /**
     * @param int|null $compra_id
     */
    public function setCompraId($compra_id) {
        $this->compra_id = $compra_id;
    }

    /**
     * @return mixed
     */
    public function getDataOrcamento() {
        return Formatos::dataApp($this->data_orcamento);
    }

    /**
     * @param mixed $data_orcamento
     */
    public function setDataOrcamento($data_orcamento) {
        $this->data_orcamento = Formatos::dataBd($data_orcamento);
    }

    /**
     * @return mixed
     */
    public function getOrcamentoPath() {
        return $this->orcamento_path;
    }

    /**
     * @param mixed $orcamento_path
     */
    public function setOrcamentoPath($orcamento_path) {
        $this->orcamento_path = $orcamento_path;
    }

    /**
     * @return $nome_arquivo
     */
    public function getNomeArquivo() {
        return $this->nome_arquivo;
    }

    /**
     * @param string $nome_arquivo
     */
    public function setNomeArquivo($nome_arquivo) {
        $this->nome_arquivo = $nome_arquivo;
    }

    /**
     * @return int|null
     */
    public function getFornecedorId() {
        return $this->fornecedor_id;
    }

    /**
     * @param int|null $fornecedor_id
     */
    public function setFornecedorId($fornecedor_id) {
        $this->fornecedor_id = $fornecedor_id;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId() {
        return $this->empresa_id;
    }

    /**
     * @param mixed $empresa_id
     */
    public function setEmpresaId($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    /**
     * @return mixed
     */
    public function getCreated() {
        return Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created) {
        $this->created = Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified() {
        return Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified) {
        $this->modified = Formatos::dataHoraBd($modified);
    }

    /**
     * Função utilizado para salvar orçamentos de compras no BD
     */
    public function salva() {
        $c = My::con();

        if (is_null($this->compra_id)) {
            throw new \Exception("Compra obrigatório.");
        }
        
        if (is_null($this->fornecedor_id)) {
            throw new \Exception("Fornecedor obrigatório.");
        }

        if (is_null($this->nome_arquivo) || empty($this->nome_arquivo) || $this->nome_arquivo == '') {
            throw new \Exception("Nome obrigatório.");
        }

        if (is_null($this->orcamento_path) || empty($this->orcamento_path) || $this->orcamento_path == '') {
            throw new \Exception("Path obrigatório.");
        }

        $com = $c->prepare("CALL compras_orcamentos_insere(?,?,?,?,?,?,?,?)");
        $com->bind_param(
                "iisssiis", $this->compra_id, $this->fornecedor_id, $this->orcamento_path, $this->nome_arquivo, $this->data_orcamento, 
                $this->user_id, $this->empresa_id, $this->created
        );
        
        $com->execute();
    }

    /**
     * Função utilizado para excluir orçamentos do BD
     */
    public function excluiArquivo() {
        $c = My::con();
        $empresa = EMPRESA;
        if ($this->compra_id && $this->fornecedor_id) {
            $com = $c->prepare("CALL compras_orcamentos_exclui(?,?,?)");
            $com->bind_param(
                    "iii", $empresa, $this->compra_id, $this->fornecedor_id
            );
            $com->execute();
        }
    }

    /**
     * @param $compra_id
     * @return array
     * @throws Exception
     */
    public static function seleciona($compra_id) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $com = $c->prepare("CALL compras_orcamentos_seleciona(?,?)");
            $com->bind_param(
                    "ii", $empresa, $compra_id);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $compra_id
     * @param $aprovado - (S)im / (N)ão
     * @return array
     * @throws Exception
     */
    public static function selecionaOrcamentos($compra_id, $aprovado, $situacao = null) {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $situacao = (is_null($situacao) || $situacao == '' || empty($situacao)) ? null : $situacao;
            $com = $c->prepare("CALL compras_orcamentos_sel(?,?,?,?)");
            $com->bind_param(
                    "iiss", $empresa, $compra_id, $aprovado, $situacao);
            $com->execute();
            $r = $com->get_result();
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
