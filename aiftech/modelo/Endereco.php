<?php

namespace modelo;

use bd\My;

class Endereco
{
    private $id;
    private $cep;
    private $logradouro;
    private $bairro;
    private $localidade;
    private $estado;
    private $estado_sigla;
    private $novo;
    private $user_id;
    private $created;
    private $modified;

    /**
     * Endereco constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $c = My::con();
            $com = $c->prepare("CALL endereco_seleciona(?)");
            $com->bind_param(
                "i",
                $id
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $l["id"];
                $this->logradouro = $l["logradouro"];
                $this->bairro = $l["bairro"];
                $this->cep = $l["cep"];
                $this->localidade = $l["localidade"];
                $this->estado = $l["estado_id"];
                $this->estado_sigla = $l["sigla"];
                $this->novo = $l["novo"];
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
    public function getNovo()
    {
        return $this->novo;
    }

    /**
     * @param string $id
     */
    public function setNovo($novo)
    {
        $this->novo = $novo;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param mixed $logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return \bd\Formatos::cepApp($this->cep);
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = \bd\Formatos::cepBd($cep);
    }

    /**
     * @return mixed
     */
    public function getLocalidade()
    {
        return $this->localidade;
    }

    /**
     * @param mixed $localidade
     */
    public function setLocalidade($localidade)
    {
        $this->localidade = $localidade;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return \bd\Formatos::inteiro($this->estado);
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = \bd\Formatos::inteiro($estado);
    }

    /**
     * @return mixed
     */
    public function getEstadoSigla()
    {
        return $this->estado_sigla;
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

    public function salva()
    {
        $c = My::con();
        if (!$this->logradouro) {
            throw new \Exception("Logradouro obrigatório.");
        }

        if (!$this->bairro) {
            throw new \Exception("Bairro obrigatório.");
        }

        if (!$this->cep) {
            throw new \Exception("CEP obrigatório.");
        }

        if (!$this->localidade) {
            throw new \Exception("Cidade obrigatória.");
        }

        if (!$this->estado) {
            throw new \Exception("Estado obrigatório.");
        }

        if (!$this->id) {
            $com = $c->prepare("CALL endereco_insere(?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "ssssisiss",
                $this->logradouro,
                $this->bairro,
                $this->cep,
                $this->localidade,
                $this->estado,
                $this->novo,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->id = $l["id"];
            $c->next_result();
        } else {
            $com = $c->prepare("CALL endereco_altera(?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssisiss",
                $this->id,
                $this->logradouro,
                $this->bairro,
                $this->cep,
                $this->localidade,
                $this->estado,
                $this->novo,
                $this->user_id,
                $this->created,
                $this->modified
            );
            $com->execute();
        }
    }

    public static function selecionaEndereco($cep, $logradouro)
    {
        $c = My::con();
        $arr_log = explode(' ', $logradouro);
        $filtro = '';
        for ($i = 0; $i < count($arr_log); $i++) {
            $filtro .= ' OR logradouro LIKE \'%' . $arr_log[$i] . ' ' . (($i + 1) == count($arr_log) ? '' : $arr_log[$i + 1]) . '%\'';
        }
        $filtro = str_replace(' %', '%', $filtro);
        $query = "SELECT *
                  FROM enderecos
                  WHERE cep = $cep
                    AND (logradouro LIKE '%$logradouro%'
                          $filtro
                         )";
        $r = $c->query($query);
        $ret = [];
        while ($l = $r->fetch_assoc()) {
            $ret[] = $l;
        }
        return $ret;
    }

    public static function selecionaEnderecosPorCepBd($cep)
    {
        $c = My::con();
        $r = $c->query("CALL enderecos_seleciona($cep)");
        $ret = [];
        while ($l = $r->fetch_assoc()) {
            $ret[] = $l;
        }
        return $ret;
    }

    public static function selecionaPorCepBd($cep)
    {
        $c = My::con();
        $r = $c->query("CALL enderecos_seleciona($cep)");
        $l = $r->fetch_assoc();
        $c->next_result();
        return $l;
    }

    public static function selecionaPorCepWs($cep)
    {
        $ch = curl_init();
        if (!$ch) {
            throw new \Exception(curl_error($ch));
        }

        $options = array(
            CURLOPT_URL =>
                "https://viacep.com.br/ws/$cep/json",
            CURLOPT_RETURNTRANSFER => 1
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        if (!$result) {
            throw new \Exception("ERRO AO FAZER A REQUISIÇÃO " . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}