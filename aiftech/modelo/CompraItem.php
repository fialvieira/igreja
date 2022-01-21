<?php

namespace modelo;

use bd\My;

class CompraItem
{

    private $compra_id;
    private $produto_id;
    private $quantidade;
    private $valor_unitario;
    private $valor_total;
    private $fornecedor_id;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;

    /**
     * CompraItem constructor.
     * @param int $compra_id
     * @param int $produto_id
     * @throws \Exception
     */
    public function __construct($compra_id = null, $produto_id = null)
    {
        if (!is_null($compra_id) && !is_null($produto_id)) {
            $c = My::con();
            $r = $c->query("CALL compras_item_seleciona($compra_id, $produto_id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->compra_id = $compra_id;
                $this->produto_id = $produto_id;
                $this->quantidade = $l["quantidade"];
                $this->valor_unitario = $l["valor_unitario"];
                $this->valor_total = $l["valor_total"];
                $this->fornecedor_id_id = $l["fornecedores_id"];
                $this->user_id = $l["user_id"];
                $this->empresa_id = $l["empresa_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
            }
            $c->next_result();
        }
    }

    /**
     * @return int Id da compra
     */
    public function getCompraId()
    {
        return $this->compra_id;
    }

    /**
     * @param int $compra_id
     */
    public function setCompraId($compra_id)
    {
        $this->compra_id = \bd\Formatos::inteiro($compra_id);
    }

    /**
     * @return int Id do produto
     */
    public function getProdutoId()
    {
        return $this->produto_id;
    }

    /**
     * @param int $produto_id
     */
    public function setProdutoId($produto_id)
    {
        $this->produto_id = \bd\Formatos::inteiro($produto_id);
    }

    /**
     * @return float quantidade
     */
    public function getQuantidade()
    {
        return \bd\Formatos::moeda($this->justificativa);
    }

    /**
     * @param float $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = \bd\Formatos::real($quantidade);
    }

    /**
     * @return moeda valor unitário
     */
    public function getValorUnitario()
    {
        return \bd\Formatos::moeda($this->valor_unitario);
    }

    /**
     * @param float $valor_unitario
     */
    public function setValorUnitario($valor_unitario)
    {
        $this->valor_unitario = \bd\Formatos::real($valor_unitario);
    }

    /**
     * @return moeda valor total
     */
    public function getValorTotal()
    {
        return \bd\Formatos::moeda($this->valor_total);
    }

    /**
     * @param float $valor_total
     */
    public function setValorTotal($valor_total)
    {
        $this->valor_total = \bd\Formatos::real($valor_total);
    }

    /**
     * @return int Id do fornecedor
     */
    public function getFornecedorId()
    {
        return $this->fornecedor_id;
    }

    /**
     * @param int $fornecedor_id
     */
    public function setFornecedorId($fornecedor_id)
    {
        $this->fornecedor_id = \bd\Formatos::inteiro($fornecedor_id);
    }

    /**
     * @return int Usuário que inseriou / editou
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = \bd\Formatos::inteiro($user_id);
    }

    /**
     * @return int empresa responsável
     */
    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    /**
     * @param int $empresa_id
     */
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = \bd\Formatos::inteiro($empresa_id);
    }

    /**
     * @return datetime data de criação/inserção
     */
    public function getCreated()
    {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return datetime data de modificação
     */
    public function getModified()
    {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param datetime $modified
     */
    public function setModified($modified)
    {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    /**
     * Função para salvar os itens (produtos) de determinada Compra
     */
    public function salva()
    {
        $c = My::con();

//        if ($this->id) {
//            $com = $c->prepare("CALL solicitacao_compra_altera(?,?,?,?,?,?)");
//            $com->bind_param(
//                    "issiis", $this->id, $this->situacao, $this->justificativa, $this->user_id, $this->empresa_id, $this->modified
//            );
//            $com->execute();
//        } else {
        $com = $c->prepare("CALL compras_itens_insere(?,?,?,?,?,?,?,?,?)");
        $com->bind_param(
            "iidddiiis", $this->compra_id, $this->produto_id, $this->quantidade, $this->valor_unitario,
            $this->valor_total,
            $this->fornecedor_id, $this->user_id, $this->empresa_id, $this->created
        );
        $com->execute();
//        $r = $com->get_result();
//        $l = $r->fetch_assoc();
//
//        $this->id = $l["id"];
//
//        $c->next_result();
//        }
    }

    /**
     * Função estática para excluir um item de compra
     * @param int $compra_id Código da compra
     * @param int $produto_id Código do produto
     */
    public static function excluiItem($compra_id, $produto_id)
    {
        $c = My::con();

        $empresa = EMPRESA;

        if ($compra_id && $produto_id) {
            $com = $c->prepare("CALL compras_itens_exclui(?,?,?)");
            $com->bind_param(
                "iii", $compra_id, $produto_id, $empresa
            );
            $com->execute();
        }
    }

    /**
     * Função estática que retorna os itens (produtos) das compras
     * @param int $compra_id Id da Compra
     * @return array Lista de itens da compra
     * @throws \Exception
     */
    public static function seleciona($compra_id)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $com = $c->prepare("CALL compras_itens_seleciona(?,?)");
            $com->bind_param("ii", $empresa, $compra_id);
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
