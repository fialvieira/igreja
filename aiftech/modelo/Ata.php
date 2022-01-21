<?php

namespace modelo;

use bd\My;
use mysql_xdevapi\Exception;

class Ata
{

    private $id;
    private $num;
    private $data;
    private $tipo_ata;
    private $tipo_desc;
    private $presidencia;
    private $presidencia_nome;
    private $tx_abertura;
    private $tx_corpo;
    private $tx_encerramento;
    private $secretario;
    private $secretario_nome;
    private $user_id;
    private $empresa_id;
    private $created;
    private $modified;
    private $ata_ft;
    private $finalizado;

    /**
     * Ata constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $c = My::con();
            $r = $c->query("CALL ata_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->num = $l["num"];
                $this->data = $l["data"];
                $this->tipo_ata = $l["tipo_ata"];
                $this->tipo_desc = $l["tipo_desc"];
                $this->presidencia = $l["presidencia"];
                $this->presidencia_nome = $l["presidencia_nome"];
                $this->tx_abertura = $l["tx_abertura"];
                $this->tx_corpo = $l["tx_corpo"];
                $this->tx_encerramento = $l["tx_encerramento"];
                $this->secretario = $l["secretario"];
                $this->secretario_nome = $l["secretario_nome"];
                $this->user_id = $l["user_id"];
                $this->empresa_id = $l["empresa_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->ata_ft = $l["ata_ft"];
                $this->finalizado = $l["finalizado"];
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
        $this->id = \bd\Formatos::inteiro($id);
    }

    /**
     * @return mixed
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param mixed $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return \bd\Formatos::dataApp($this->data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = \bd\Formatos::dataBd($data);
    }

    /**
     * @return mixed
     */
    public function getTipoAta()
    {
        return $this->tipo_ata;
    }

    /**
     * @param mixed $tipo_ata
     */
    public function setTipoAta($tipo_ata)
    {
        $this->tipo_ata = $tipo_ata;
    }

    /**
     * @return mixed
     */
    public function getTipoDesc()
    {
        return $this->tipo_desc;
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
        $this->user_id = \bd\Formatos::inteiro($user_id);
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

    /**
     * @return mixed
     */
    public function getAtaFt()
    {
        return $this->ata_ft;
    }

    /**
     * @param mixed $ata_ft
     */
    public function setAtaFt($ata_ft)
    {
        $this->ata_ft = $ata_ft;
    }

    public function getPresidencia()
    {
        return $this->presidencia;
    }

    public function getTxAbertura()
    {
        return $this->tx_abertura;
    }

    public function getTxCorpo()
    {
        return $this->tx_corpo;
    }

    public function getTxEncerramento()
    {
        return $this->tx_encerramento;
    }

    public function getSecretario()
    {
        return $this->secretario;
    }

    public function setPresidencia($presidencia)
    {
        $this->presidencia = $presidencia;
    }

    public function setTxAbertura($tx_abertura)
    {
        $this->tx_abertura = $tx_abertura;
    }

    public function setTxCorpo($tx_corpo)
    {
        $this->tx_corpo = $tx_corpo;
    }

    public function setTxEncerramento($tx_encerramento)
    {
        $this->tx_encerramento = $tx_encerramento;
    }

    public function setSecretario($secretario)
    {
        $this->secretario = $secretario;
    }

    public function getPresidenciaNome()
    {
        return $this->presidencia_nome;
    }

    public function getSecretarioNome()
    {
        return $this->secretario_nome;
    }

    public function getFinalizado()
    {
        return $this->finalizado;
    }

    public function setFinalizado($finalizado)
    {
        $this->finalizado = $finalizado;
    }

    public function salva()
    {
        $c = My::con();

        if ($this->id) {
            $com = $c->prepare("CALL ata_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "isiisssiiissss", $this->id, $this->data, $this->tipo_ata, $this->presidencia, $this->tx_abertura, $this->tx_corpo, $this->tx_encerramento, $this->secretario, $this->user_id, $this->empresa_id, $this->created, $this->modified, $this->ata_ft, $this->finalizado
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL ata_insere(?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "siisssiiisss", $this->data, $this->tipo_ata, $this->presidencia, $this->tx_abertura, $this->tx_corpo, $this->tx_encerramento, $this->secretario, $this->user_id, $this->empresa_id, $this->created, $this->modified, $this->ata_ft
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();

            $this->id = $l["id"];
            $this->num = $l["num"];

            $c->next_result();
        }
    }

    public static function seleciona($valor = null, $limit = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($valor == "" || !isset($valor) || is_null($valor)) {
            $com = $c->prepare("CALL atas_seleciona(?,?)");
            $com->bind_param(
                "ii", $empresa, $limit
            );
        } else {
            $com = $c->prepare("CALL atas_fulltext_seleciona(?, ?)");
            $com->bind_param(
                "ii", $valor, $empresa
            );
            /* $r = $c->query("CALL atas_fulltext_seleciona('$valor'," . EMPRESA . ")");*/
        }
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function selecionaPorNum($num)
    {
        $c = My::con();

        $r = $c->query("SELECT id 
                    FROM atas
                    WHERE num = $num
                      AND empresa_id = " . EMPRESA);
        $l = $r->fetch_assoc();
        return $l;
    }

//----> ASSUNTOS    
//  public static function selecionaAssuntos($ata) {
//    $c = My::con();
//
//    $r = $c->query("CALL ata_assuntos_seleciona($ata)");
//    $retorno = [];
//    while ($l = $r->fetch_assoc()) {
//      $retorno[] = $l;
//    }
//
//    $c->next_result();
//    return $retorno;
//  }
//  public function salvaAssunto($titulo, $texto, $id, $status) {
//    $c = My::con();
//
//    if (is_null($titulo) || empty($titulo) || $titulo == '') {
//      throw new \Exception("Título obrigatório.");
//    }
//    if (is_null($texto) || empty($texto) || $texto == '') {
//      throw new \Exception("Texto obrigatório.");
//    }
//    
//    if ($status == 'upd') {
//      $com = $c->prepare("CALL ata_assunto_altera(?,?,?,?,?,?)");
//      $com->bind_param(
//              "iissis", $this->id, $id, $titulo, $texto, $this->user_id, $this->modified
//      );
//      $com->execute();
//    } else {
//      $com = $c->prepare("CALL ata_assunto_insere(?,?,?,?,?,?,?)");
//      $com->bind_param(
//              "issiiss", $this->id, $titulo, $texto, $this->user_id, $this->empresa_id, $this->created, $this->modified
//      );
//      $com->execute();
//      $r = $com->get_result();
//      $l = $r->fetch_assoc();
//
//      $c->next_result();
//      return $l;
//    }
//  }
//  public function excluiAssunto($id) {
//    $c = My::con();
//
//    if ($this->id && $id) {
//      $com = $c->prepare("CALL ata_assunto_exclui(?,?)");
//      $com->bind_param(
//              "ii", $this->id, $id
//      );
//      $com->execute();
//    }
//  }
//<----    
//----> ARQUIVOS  
    public static function selecionaArquivos($ata, $ata_digit = null, $id = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if (is_null($id)) {
            if (is_null($ata_digit)) {
                $ata_digit = 'T';
            }

            $r = $c->query("CALL ata_arquivos_seleciona($empresa, $ata, '$ata_digit')");
            if ($ata_digit == 'S') { // Arquivo é Ata digitalizada, sempre será apenas uma Ata digitalizada (Marlon 31/01/2018)
                $retorno = $r->fetch_assoc();
            } else {
                $retorno = [];
                while ($l = $r->fetch_assoc()) {
                    $retorno[] = $l;
                }
            }
        } else {
            $r = $c->query("CALL ata_arquivo_seleciona($empresa, $id)");
            $retorno = $r->fetch_assoc();
        }
        $c->next_result();
        return $retorno;
    }

    public function salvaArquivo($path, $nome, $ata_digit)
    {
        $c = My::con();
        $hoje = date('Y-m-d');
        $modified = NULL;
        if (is_null($this->id)) {
            throw new \Exception("Ata obrigatório.");
        }

        if (is_null($nome) || empty($nome) || $nome == '') {
            throw new \Exception("Nome obrigatório.");
        }

        if (is_null($path) || empty($path) || $path == '') {
            throw new \Exception("Path obrigatório.");
        }

        $com = $c->prepare("CALL ata_arquivo_insere(?,?,?,?,?,?,?,?,?)");
        $com->bind_param(
            "issssiiss", $this->id, $path, $nome, $hoje, $ata_digit, $this->user_id, $this->empresa_id, $this->created, $modified
        );
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();

        $c->next_result();
        return $l;
    }

    public function excluiArquivo($id)
    {
        $c = My::con();
        if ($id) {
            $com = $c->prepare("CALL ata_arquivo_exclui(?)");
            $com->bind_param(
                "i", $id
            );
            $com->execute();
        }
    }

    public static function listaAtasDocsNumero()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $com = $c->prepare("SELECT DISTINCT IFNULL(a.`id`, d.`ata_id`) id, IFNULL(a.`num`, d.`num`) num
                                      FROM atas a
                                      LEFT JOIN documentos d
                                             ON a.`id` = d.`ata_id`
                                            AND a.`empresa_id` = d.`empresa_id`
                                      WHERE a.`empresa_id` = ?
                                      ORDER BY IFNULL(a.`num`, d.`num`)");
            $com->bind_param(
                "i",
                $empresa
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

//<----  
//----> PARTICIPANTES    
//  public static function selecionaParticipantes($ata, $membro_id = null) {
//    $c = My::con();
//    if (is_null($membro_id)) {
//      $r = $c->query("CALL ata_participantes_seleciona($ata)");
//      $retorno = [];
//      while ($l = $r->fetch_assoc()) {
//        $retorno[] = $l;
//      }
//    } else {
//      $r = $c->query("CALL ata_participante_seleciona($ata,$membro_id)");
//      $retorno = $r->fetch_assoc();
//    }
//    $c->next_result();
//    return $retorno;
//  }
//  public function salvaParticipante($membro) {
//    $c = My::con();
//
//    if (is_null($membro) || empty($membro) || $membro == '') {
//      throw new \Exception("Participante obrigatório.");
//    }
//
//    $participante = self::selecionaParticipantes($this->id, $membro);
//    if (!$participante) {
//      $com = $c->prepare("CALL ata_participante_insere(?,?)");
//      $com->bind_param(
//              "ii", $this->id, $membro
//      );
//      $com->execute();
//    }
//  }
//
//  public function excluiParticipante($membro) {
//    $c = My::con();
//    if ($this->id && $membro) {
//      $com = $c->prepare("CALL ata_participante_exclui(?,?)");
//      $com->bind_param(
//              "ii", $this->id, $membro
//      );
//      $com->execute();
//    }
//  }
//<----  
}