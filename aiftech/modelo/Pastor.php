<?php

namespace modelo;

use bd\My;

class Pastor {

    private $id;
    private $nome;
    private $tratamento;
    private $dt_entrada;
    private $dt_saida;
    private $ata_entrada;
    private $ata_saida;
    private $categoria;
    private $user_id;
    private $created;
    private $modified;

//  private $ativo;

    const FUNCAO = [
        '' => '',
        'T' => 'Títular',
        'A' => 'Auxiliar',
        'D' => 'Desligado'
    ];

    /**
     * Pastor constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null) {
        if (!is_null($id)) {
            $id = $id;
            $c = My::con();
            $r = $c->query("CALL pastor_seleciona($id," . EMPRESA . ")");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->nome = $l["nome"];
                $this->tratamento = $l["tratamento"];
                $this->dt_entrada = $l["dt_entrada"];
                $this->ata_entrada = $l["ata_entrada"];
                $this->dt_saida = $l["dt_saida"];
                $this->ata_saida = $l["ata_saida"];
                $this->categoria = $l["categoria"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
//        $this->ativo = $l["ativo"];
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
        $this->id = $id;
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
    public function getTratamento() {
        return $this->tratamento;
    }

    /**
     * @param mixed $tratamento
     */
    public function setTratamento($tratamento) {
        $this->tratamento = $tratamento;
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
    public function getCreated() {
        return \bd\Formatos::dataHoraApp($this->created);
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created) {
        $this->created = \bd\Formatos::dataHoraBd($created);
    }

    /**
     * @return mixed
     */
    public function getModified() {
        return \bd\Formatos::dataHoraApp($this->modified);
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified) {
        $this->modified = \bd\Formatos::dataHoraBd($modified);
    }

    public function getDtEntrada() {
        return \bd\Formatos::dataApp($this->dt_entrada);
    }

    public function getDtSaida() {
        return \bd\Formatos::dataApp($this->dt_saida);
    }

    public function getAtaEntrada() {
        return $this->ata_entrada;
    }

    public function getAtaSaida() {
        return $this->ata_saida;
    }

    public function setDtEntrada($dt_entrada) {
        $this->dt_entrada = \bd\Formatos::dataBd($dt_entrada);
    }

    public function setDtSaida($dt_saida) {
        $this->dt_saida = \bd\Formatos::dataBd($dt_saida);
    }

    public function setAtaEntrada($ata_entrada) {
        $this->ata_entrada = $ata_entrada;
    }

    public function setAtaSaida($ata_saida) {
        $this->ata_saida = $ata_saida;
    }

    /**
     * @return mixed
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
//  public function getAtivo() {
//    return $this->ativo;
//  }
//  
//  /**
//   * @param mixed $modified
//   */
//  public function setAtivo($ativo) {
//    $this->ativo = $ativo;
//  }

    public function salva($empresa = null) {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }
        if (is_null($empresa) || !isset($empresa) || $empresa == '') {
            $empresa = EMPRESA;
        }
        $user_empresa = EMPRESA . ' - ' . $this->user_id;
        if ($this->id) {
            $com = $c->prepare("CALL pastor_altera(?,?,?,?,?,?)");
            $com->bind_param(
                    "ississ", $this->id, $this->nome, $this->tratamento, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
            // insere/altera na associativa
            if (($this->dt_entrada && $this->ata_entrada) || $this->categoria) {
                $com = $c->prepare("CALL assoc_empresa_pastor_ins_upd(?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                        "iisisissss", $empresa, $this->id, $this->dt_entrada, $this->ata_entrada, $this->dt_saida, $this->ata_saida, $this->categoria, $user_empresa, $this->created, $this->modified
                );
                $com->execute();
            }
        } else {
            $com = $c->prepare("CALL pastor_insere(?,?,?,?,?)");
            $com->bind_param(
                    "sssss", $this->nome, $this->tratamento, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];

            $c->next_result();
            // insere/altera na associativa
            if (($this->dt_entrada && $this->ata_entrada) || $this->categoria) {
                $com = $c->prepare("CALL assoc_empresa_pastor_ins_upd(?,?,?,?,?,?,?,?,?,?)");
                $com->bind_param(
                        "iisisisiss", $empresa, $this->id, $this->dt_entrada, $this->ata_entrada, $this->dt_saida, $this->ata_saida, $this->categoria, $user_empresa, $this->created, $this->modified
                );
                $com->execute();
            }
        }
    }

    public static function listaPastores() {
        $c = My::con();
        $query = 'SELECT *
                  FROM pastores
                  ORDER BY nome';
        $r = $c->query($query);
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function seleciona() {
        $c = My::con();
        $r = $c->query('CALL pastores_seleciona(' . EMPRESA . ')');
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function existeTitular($empresa = null) {
        $c = My::con();
        if (is_null($empresa) || !isset($empresa) || $empresa == '') {
            $empresa = EMPRESA;
        }
        $r = $c->query("SELECT P.tratamento, P.nome, P.id 
                        FROM assoc_empresas_pastores EP
                        LEFT JOIN pastores P
                          ON EP.pastor_id = P.id
                        WHERE EP.empresa_id = " . $empresa . "
                          AND EP.categoria = 'T'");
        $l = $r->fetch_assoc();
        return $l;
    }

}

?>