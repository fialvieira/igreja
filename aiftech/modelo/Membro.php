<?php

namespace modelo;

use bd\Formatos;
use bd\My;

class Membro
{

    const MEMBRO = 'M';
    const VISITANTE = 'V';
    const TIPOS = [
        'M' => 'MEMBRO',
        'V' => 'VISITANTE'
    ];
    const MASCULINO = 'M';
    const FEMININO = 'F';
    const OUTROS = 'O';
    const SEXO = [
        'M' => 'Masculino',
        'F' => 'Feminio',
        'O' => 'Outros'
    ];
    const SOLTEIRO = 0;
    const CASADO = 1;
    const DIVORCIADO = 2;
    const VIUVO = 3;
    const SEPARADO = 4;
    const ESTADO_CIVIL = [
        'Solteiro(a)',
        'Casado(a)',
        'Divorciado(a)',
        'Viúvo(a)',
        'Separado(a)'
    ];

    private $id;
    private $frequencia;
    private $nome;
    private $sexo;
    private $datanascimento;
    private $naturalidade;
    private $estado_id;
    private $estadocivil;
    private $latitude;
    private $longitude;
    private $rg;
    private $orgao_emissor;
    private $data_expedicao;
    private $cpf;
    private $email;
    private $fone;
    private $cel;
    private $escolaridade_id;
    private $profissao_id;
    private $empresa;
    private $databatismo;
    private $igrejabatismo;
    private $pastorbatismo;
    private $ultimaigreja;
    private $datamembro;
    private $cargo_id;
    private $cargo_ativo;
    private $empresa_id;
    private $user_id;
    private $created;
    private $modified;
    private $tipo;
    private $igreja_anterior;
    private $endereco_id;
    private $complemento;
    private $numero;
    private $txts;
    private $imagem;
    private $departamento_id;
    private $data_casamento;
    private $local_id;
    private $ata_batismo;

    /**
     * Membro constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $id = \bd\Formatos::inteiro($id);
            $c = My::con();
            $r = $c->query("CALL membro_seleciona($id)");
            $l = $r->fetch_assoc();
            if ($l) {
                $this->id = $id;
                $this->frequencia = $l["frequencia_id"];
                $this->nome = $l["nome"];
                $this->sexo = $l["sexo"];
                $this->datanascimento = $l["datanascimento"];
                $this->naturalidade = $l["naturalidade"];
                $this->estado_id = $l["estado_id"];
                $this->estadocivil = $l["estadocivil"];
                $this->data_casamento = $l["data_casamento"];
                $this->latitude = $l["latitude"];
                $this->longitude = $l["longitude"];
                $this->rg = $l["rg"];
                $this->orgao_emissor = $l["orgao_emissor"];
                $this->data_expedicao = $l["data_expedicao"];
                $this->cpf = $l["cpf"];
                $this->email = $l["email"];
                $this->fone = $l["fone"];
                $this->cel = $l["cel"];
                $this->escolaridade_id = $l["escolaridade_id"];
                $this->profissao_id = $l["profissao_id"];
                $this->empresa = $l["empresa"];
                $this->endereco_id = $l["enderecos_id"];
                $this->complemento = $l["enderecos_complemento"];
                $this->numero = $l["enderecos_numero"];
                $this->databatismo = $l["databatismo"];
                $this->igrejabatismo = $l["igrejas_id"];
                $this->pastorbatismo = $l["pastorbatismo"];
                $this->ultimaigreja = $l["ultimaigreja"];
                $this->datamembro = $l["datamembro"];
                $this->cargo_id = $l["cargo_id"];
                $this->cargo_ativo = $l['abreviacao'];
                $this->empresa_id = $l["empresa_id"];
                $this->user_id = $l["user_id"];
                $this->created = $l["created"];
                $this->modified = $l["modified"];
                $this->tipo = $l["tipo"];
                $this->imagem = $l["foto"];
                $this->local_id = $l["local_id"];
                $this->ata_batismo = $l["ata_batismo"];
            }
            $c->next_result();
        }
    }

    /**
     * @return integer
     */
    public function getAtaBatismo()
    {
        return \bd\Formatos::inteiro($this->ata_batismo);
    }

    /**
     * @param integer $ata_batismo
     */
    public function setAtaBatismo($ata_batismo)
    {
        $this->ata_batismo = \bd\Formatos::inteiro($ata_batismo);
    }

    /**
     * @return integer
     */
    public function getLocalId()
    {
        return \bd\Formatos::inteiro($this->local_id);
    }

    /**
     * @param integer $local_id
     */
    public function setLocalId($local_id)
    {
        $this->local_id = \bd\Formatos::inteiro($local_id);
    }

    /**
     * @return mixed
     */
    public function getEnderecosId()
    {
        return \bd\Formatos::inteiro($this->endereco_id);
    }

    /**
     * @param mixed $enderecos_id
     */
    public function setEnderecosId($enderecos_id)
    {
        $this->endereco_id = \bd\Formatos::inteiro($enderecos_id);
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
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
    public function getFrequencia()
    {
        return \bd\Formatos::inteiro($this->frequencia);
    }

    /**
     * @param mixed $frequencia_id
     */
    public function setFrequencia($frequencia_id)
    {
        $this->frequencia = \bd\Formatos::inteiro($frequencia_id);
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
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getDatanascimento()
    {
        return Formatos::dataApp(($this->datanascimento != '0000-00-00') ? $this->datanascimento : '');
    }

    /**
     * @param mixed $datanascimento
     */
    public function setDatanascimento($datanascimento)
    {
        $this->datanascimento = Formatos::dataBd($datanascimento);
    }

    /**
     * @return mixed
     */
    public function getDataCasamento()
    {
        return Formatos::dataApp(($this->data_casamento != '0000-00-00') ? $this->data_casamento : '');
    }

    /**
     * @param mixed $data_casamento
     */
    public function setDataCasamento($data_casamento)
    {
        $this->data_casamento = \bd\Formatos::dataBd($data_casamento);
    }

    /**
     * @return mixed
     */
    public function getNaturalidade()
    {
        return $this->naturalidade;
    }

    /**
     * @param mixed $naturalidade
     */
    public function setNaturalidade($naturalidade)
    {
        $this->naturalidade = $naturalidade;
    }

    /**
     * @return mixed
     */
    public function getEstadoId()
    {
        return \bd\Formatos::inteiro($this->estado_id);
    }

    /**
     * @param mixed $estado_id
     */
    public function setEstadoId($estado_id)
    {
        $this->estado_id = \bd\Formatos::inteiro($estado_id);
    }

    /**
     * @return mixed
     */
    public function getEstadoCivil()
    {
        return $this->estadocivil;
    }

    /**
     * @param mixed $estadocivil
     */
    public function setEstadoCivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param mixed $rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * @return mixed
     */
    public function getOrgaoEmissor()
    {
        return $this->orgao_emissor;
    }

    /**
     * @param mixed $orgao_emissor
     */
    public function setOrgaoEmissor($orgao_emissor)
    {
        $this->orgao_emissor = $orgao_emissor;
    }

    /**
     * @return mixed
     */
    public function getDataExpedicao()
    {
        return Formatos::dataApp(($this->data_expedicao != '0000-00-00') ? $this->data_expedicao : '');
    }

    /**
     * @param mixed $data_expedicao
     */
    public function setDataExpedicao($data_expedicao)
    {
        $this->data_expedicao = Formatos::dataBd($data_expedicao);
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return Formatos::cpfApp($this->cpf);
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = Formatos::cpfBd($cpf);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = \bd\Formatos::email($email);
    }

    /**
     * @return mixed
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param mixed $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    /**
     * @return mixed
     */
    public function getCel()
    {
        return \bd\Formatos::telefoneApp($this->cel);
    }

    /**
     * @param mixed $cel
     */
    public function setCel($cel)
    {
        $this->cel = \bd\Formatos::telefoneBd($cel);
    }

    /**
     * @return mixed
     */
    public function getEscolaridadeId()
    {
        return \bd\Formatos::inteiro($this->escolaridade_id);
    }

    /**
     * @param mixed $escolaridade_id
     */
    public function setEscolaridadeId($escolaridade_id)
    {
        $this->escolaridade_id = \bd\Formatos::inteiro($escolaridade_id);
    }

    /**
     * @return mixed
     */
    public function getProfissaoId()
    {
        return \bd\Formatos::inteiro($this->profissao_id);
    }

    /**
     * @param mixed $profissao_id
     */
    public function setProfissaoId($profissao_id)
    {
        $this->profissao_id = \bd\Formatos::inteiro($profissao_id);
    }

    /**
     * @return mixed
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @return mixed
     */
    public function getDatabatismo()
    {
        return \bd\Formatos::dataApp(($this->databatismo != '0000-00-00') ? $this->databatismo : '');
    }

    /**
     * @param mixed $databatismo
     */
    public function setDatabatismo($databatismo)
    {
        $this->databatismo = \bd\Formatos::dataBd($databatismo);
    }

    /**
     * @return mixed
     */
    public function getIgrejabatismo()
    {
        return \bd\Formatos::inteiro($this->igrejabatismo);
    }

    /**
     * @param mixed $igrejabatismo
     */
    public function setIgrejabatismo($igrejabatismo)
    {
        $this->igrejabatismo = \bd\Formatos::inteiro($igrejabatismo);
    }

    /**
     * @return mixed
     */
    public function getPastorbatismo()
    {
        return $this->pastorbatismo;
    }

    /**
     * @param mixed $pastorbatismo
     */
    public function setPastorbatismo($pastorbatismo)
    {
        $this->pastorbatismo = Formatos::inteiro($pastorbatismo);
    }

    /**
     * @return mixed
     */
    public function getUltimaigreja()
    {
        return \bd\Formatos::inteiro($this->ultimaigreja);
    }

    /**
     * @param mixed $ultimaigreja
     */
    public function setUltimaigreja($ultimaigreja)
    {
        $this->ultimaigreja = \bd\Formatos::inteiro($ultimaigreja);
    }

    /**
     * @return mixed
     */
    public function getDatamembro()
    {
        return \bd\Formatos::dataApp(($this->datamembro != '0000-00-00') ? $this->datamembro : '');
    }

    /**
     * @param mixed $datamembro
     */
    public function setDatamembro($datamembro)
    {
        $this->datamembro = \bd\Formatos::dataBd($datamembro);
    }

    /**
     * @return mixed
     */
    public function getDepartamentosInteresse()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("CALL membro_deps_inte_sel(?,?)");
        $com->bind_param(
            "ii", $this->id, $empresa
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    /**
     * @param mixed $departamento_id
     */
    public function setDepartamentosInteresse($departamento_id)
    {
        $this->departamento_id = Formatos::inteiro($departamento_id);
    }

    /**
     * @return mixed
     */
    public function getIgrejasAnteriores()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $com = $c->prepare("CALL membro_ig_ant_sel(?,?)");
        $com->bind_param(
            "ii", $this->id, $empresa
        );
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    /**
     * @param mixed $igrejasanteriores
     */
    public function setIgrejasAnteriores($igrejasanteriores)
    {
        $this->igreja_anterior = Formatos::inteiro($igrejasanteriores);
    }

    /**
     * @return mixed
     */
    public function getCargoId()
    {
        return Formatos::inteiro($this->cargo_id);
    }

    /**
     * @param mixed $cargo_id
     */
    public function setCargoId($cargo_id)
    {
        $this->cargo_id = Formatos::inteiro($cargo_id);
    }

    /**
     * @return mixed
     */
    public function getCargoAtivo()
    {
        return $this->cargo_ativo;
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
     * @return mixed
     */
    public function getImagem()
    {
        if (strpos($this->imagem, 'fotos') > 0) {
            return $this->imagem;
        } else {
            return 'arquivos/no-image.png';
        }
    }

    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    /**
     * @param string $sel_txts
     */
    public function setTextos($sel_txts)
    {
        $this->txts = $sel_txts;
    }

    public function setFullText()
    {
        try {
            if ($this->id) {
                $c = My::con();
                $empresa = EMPRESA;
                $ft = $this->txts . ' ' . $this->nome . ' ' . tiraAcentos($this->nome) . ' ' . $this->getDatanascimento() . ' ' . $this->cpf . ' ' .
                    $this->rg . ' ' . $this->getEmail() . ' ' . $this->getFone() . ' ' . $this->getCel() . ' ' .
                    $this->getDatabatismo() . ' ' . $this->getDatamembro() . ' ' . $this->getNaturalidade();
                $com = $c->prepare("CALL membros_ft_update(?, ?, ?)");
                $com->bind_param("iis", $this->id, $empresa, $ft);
                $com->execute();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function salva()
    {
        $c = My::con();
        if (!$this->nome) {
            throw new \Exception("Nome obrigatório(a).");
        }

        if (!$this->cpf) {
            throw new \Exception("Cpf obrigatório(a).");
        }

        if (!$this->empresa_id) {
            throw new \Exception("Empresa Id obrigatório(a).");
        }

        if (!$this->user_id) {
            throw new \Exception("User Id obrigatório(a).");
        }

        if ($this->id) {
            $com = $c->prepare("CALL membro_altera(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "iissssiisssssssssiissssssiiississssii", $this->id, $this->frequencia, $this->nome, $this->sexo, $this->datanascimento, $this->naturalidade, $this->estado_id, $this->estadocivil, $this->latitude, $this->longitude, $this->rg, $this->orgao_emissor, $this->data_expedicao, $this->cpf, $this->email, $this->fone, $this->cel, $this->escolaridade_id, $this->profissao_id, $this->empresa, $this->databatismo, $this->igrejabatismo, $this->pastorbatismo, $this->ultimaigreja, $this->datamembro, $this->cargo_id, $this->empresa_id, $this->endereco_id, $this->numero, $this->complemento, $this->user_id, $this->created, $this->modified, $this->tipo, $this->data_casamento, $this->local_id, $this->ata_batismo
            );
            $com->execute();
        } else {
            $com = $c->prepare("CALL membro_insere(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $com->bind_param(
                "issssiisssssssssiissssssiiississssii", $this->frequencia, $this->nome, $this->sexo, $this->datanascimento, $this->naturalidade, $this->estado_id, $this->estadocivil, $this->latitude, $this->longitude, $this->rg, $this->orgao_emissor, $this->data_expedicao, $this->cpf, $this->email, $this->fone, $this->cel, $this->escolaridade_id, $this->profissao_id, $this->empresa, $this->databatismo, $this->igrejabatismo, $this->pastorbatismo, $this->ultimaigreja, $this->datamembro, $this->cargo_id, $this->empresa_id, $this->endereco_id, $this->numero, $this->complemento, $this->user_id, $this->created, $this->modified, $this->tipo, $this->data_casamento, $this->local_id, $this->ata_batismo
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $this->id = $l["id"];
            $c->next_result();
        }
    }

    public static function isQuorum($quorum, $idade_quorum, $dt_nascimento)
    {
        $idade = idade($dt_nascimento);
        if ($quorum === 'S' && (intval($idade) >= intval($idade_quorum))) {
            return true;
        } else {
            return false;
        }
    }

    public static function selecionaTodos()
    {
        $c = My::con();
        $empresa = EMPRESA;
        $query = 'SELECT id, nome
                  FROM membros
                  WHERE empresa_id = ?';
        $com = $c->prepare($query);
        $com->bind_param('i', $empresa);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function seleciona($valor = null, $status = null, $limit = null, $order = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($valor == "" || !isset($valor) || is_null($valor)) {
            $query = 'CALL membros_seleciona(?, ?, ?, ?)';
            $com = $c->prepare($query);
            $com->bind_param('isis', $empresa, $status, $limit, $order);
            $com->execute();
            $r = $com->get_result();
            /* $r = $c->query('CALL membros_seleciona(' . EMPRESA . ', ' . $status . ')'); */
        } else {
            $query = 'CALL membros_ft_seleciona(?, ?, ?)';
            $com = $c->prepare($query);
            $com->bind_param('sis', $valor, $empresa, $status);
            $com->execute();
            $r = $com->get_result();
            /* $r = $c->query('CALL membros_ft_seleciona(' . $valor . ', ' . EMPRESA . ', ' . $status . ')'); */
        }
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function atasMembrosSeleciona($status = null, $limit = null, $order = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $query = 'CALL atas_membros_seleciona(?, ?, ?, ?)';
        $com = $c->prepare($query);
        $com->bind_param('isis', $empresa, $status, $limit, $order);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    public static function getIdMembroPorCPF($cpf)
    {
        if ($cpf != '' || isset($cpf)) {
            $c = My::con();
            $query = 'SELECT id, nome
                      FROM membros
                      WHERE cpf = ?';
            $com = $c->prepare($query);
            $com->bind_param('s', $cpf);
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            $id = $l['id'];
            if ($id != '') {
                $ret = [
                    'MEMBRO' => true,
                    'id' => $id,
                    'nome' => $l['nome']
                ];
            } else {
                $ret = [
                    'MEMBRO' => false,
                    'id' => '',
                    'nome' => ''
                ];
            }
        } else {
            $ret = [
                'MEMBRO' => false,
                'id' => '',
                'nome' => ''
            ];
        }
        return $ret;
    }

    public static function getMembrosQuorum($tipo = null)
    { //TODO Ajustar para os novos parâmetros de quórum
        $c = My::con();
        $empresa = EMPRESA;
        $query = "CALL membros_quorum_seleciona(?, ?)";
        $com = $c->prepare($query);
        $com->bind_param('si', $tipo, $empresa);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        $c->next_result();
        return $retorno;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function listaMembrosComMovimentacao()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT DISTINCT M.`id`, M.`nome`
                      FROM membros M
                      INNER JOIN movimentacao_membros MM
                         ON M.`id` = MM.`membro_id`
                        AND M.`empresa_id` = MM.`empresa_id`
                      WHERE M.`empresa_id` = ?
                      ORDER BY M.`nome`";
            $com = $c->prepare($query);
            $com->bind_param('i', $empresa);
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

    public static function getMenoresIdade($ativo = null, $quorum = null)
    { //TODO Validar data de nascimento
        $c = My::con();
        $empresa = EMPRESA;
        $query = "SELECT m.`nome`
                        ,m.`datanascimento`
                        ,TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) idade
                  FROM membros m
                  INNER JOIN parametros_sistema ps
                    ON m.empresa_id = ps.empresa_id
                  INNER JOIN membros_frequencia mf
                    ON m.frequencia_id = mf.id
                   AND m.empresa_id = mf.empresa_id
                  WHERE m.empresa_id = ?
                    AND mf.status = IFNULL(?, mf.status)
                    AND mf.quorum = IFNULL(?, mf.quorum)
                    AND TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) < ps.idade_quorum
                    AND m.`datanascimento` <> '2016-01-01'
                  ORDER BY m.nome";
        $com = $c->prepare($query);
        $com->bind_param('iss', $empresa, $ativo, $quorum);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
        return $retorno;
    }

    public static function getTotalMenoresAtivos($ativo = null, $quorum = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        $query = "SELECT 	COUNT(*) TOTAL_MENORES
                  FROM membros m
                  INNER JOIN parametros_sistema ps
                    ON m.empresa_id = ps.empresa_id
                  INNER JOIN membros_frequencia mf
                    ON m.frequencia_id = mf.id
                   AND m.empresa_id = mf.empresa_id
                  WHERE m.empresa_id = ?
                    AND mf.status = IFNULL(?, mf.status)
                    AND mf.quorum = IFNULL(?, mf.quorum)
                    AND TIMESTAMPDIFF(YEAR, m.datanascimento, CURDATE()) < ps.idade_quorum";
        $com = $c->prepare($query);
        $com->bind_param('iss', $empresa, $ativo, $quorum);
        $com->execute();
        $r = $com->get_result();
        $l = $r->fetch_assoc();
        return $l['TOTAL_MENORES'];
    }

    /**
     * Função retorna lista de membros conforme tipo de cargo informado
     * @param char(1) $tipo Tipo do cargo desejado, sendo (P)residente ou (S)ecretário(a)
     * @return array Dados dos membros que estão ativos no cargo desejado (cpf, id, nome, email)
     */
    public static function getMembroByCargo($tipo)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($tipo == 'P') {
//            $cargos = "SELECT id_presidentes_ata cargos
//                              FROM parametros_sistema
//                              WHERE empresa_id = $empresa ";
//            $r = $c->query($cargos);
//            $l = $r->fetch_assoc();
//            $arrCargos = explode(',', $l['cargos']);
            $arrCargos = self::getCargoPresidenteEmpresa();
            $cargos = '';
            foreach ($arrCargos as $value) {
                $cargos .= $value . ',';
            }
            $cargos = substr($cargos, 0, -1);
            $query = 'SELECT DISTINCT M.cpf, M.id, M.nome, M.email
                      FROM assoc_membros_cargos_departamentos AMCD
                      LEFT JOIN membros M
                        ON AMCD.membro_id = M.id
                      LEFT JOIN cargos C
                        ON AMCD.cargo_id = C.id
                      WHERE AMCD.ativo = \'S\'
                        AND C.empresa_id = ?
                        AND C.id IN (' . $cargos . ')
                      ORDER BY M.nome';
        } elseif ($tipo == 'S') {
//            $cargos = "SELECT id_secretarios_ata cargos
//                        FROM parametros_sistema
//                        WHERE empresa_id = $empresa ";
//            $r = $c->query($cargos);
//            $l = $r->fetch_assoc();
//            $arrCargos = explode(',', $l['cargos']);
            $arrCargos = self::getCargoSecretarioEmpresa();
            $cargos = '';
            foreach ($arrCargos as $value) {
                $cargos .= $value . ',';
            }
            $cargos = substr($cargos, 0, -1);
            $query = "SELECT TBL.*
                      FROM (SELECT M.cpf, M.id, M.nome, '1' ordem
                            FROM assoc_membros_cargos_departamentos AMCD
                            LEFT JOIN membros M
                              ON AMCD.membro_id = M.id
                            LEFT JOIN cargos C
                              ON AMCD.cargo_id = C.id
                            WHERE AMCD.ativo = 'S'
                              AND C.empresa_id = ?
                              AND C.id IN ($cargos)
                            UNION
                            SELECT M.cpf, M.id, M.nome, '2' ordem
                            FROM membros M
                            LEFT JOIN assoc_membros_cargos_departamentos AMCD
                              ON AMCD.membro_id = M.id
                            LEFT JOIN cargos C
                              ON AMCD.cargo_id = C.id
                            WHERE M.empresa_id = $empresa
                              AND IFNULL(C.id,'0') NOT IN ($cargos)) TBL    
                      ORDER BY TBL.ordem, TBL.nome";
        }
        $com = $c->prepare($query);
        $com->bind_param('i', $empresa);
        $com->execute();
        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }
//        $c->next_result();
        return $retorno;
    }

    public static function getCargoAtasByMembro($tipo, $id, $ano = null)
    {
        $c = My::con();
        $empresa = EMPRESA;
        if ($tipo == 'P') {
            $arrCargos = self::getCargoPresidenteEmpresa();
            $cargos = '';
            foreach ($arrCargos as $value) {
                $cargos .= $value . ',';
            }
            $cargos = substr($cargos, 0, -1);
            $query = "SELECT mcd.*,m.id, m.nome, m.rg, m.cpf, c.nome cargo, c.abreviacao
                      FROM assoc_membros_cargos_departamentos mcd
                      INNER JOIN membros m
                        ON mcd.membro_id = m.id
                      INNER JOIN cargos c
                        ON mcd.cargo_id = c.id  
                      WHERE mcd.empresa_id = $empresa 
                        AND mcd.membro_id = $id
                        AND mcd.periodo = '$ano'
                        AND mcd.cargo_id IN ($cargos)    
                      ORDER BY mcd.periodo DESC, mcd.ativo DESC";
//            $query = 'SELECT M.cpf, M.id, M.nome
//                      FROM assoc_membros_cargos_departamentos AMCD
//                      LEFT JOIN membros M
//                        ON AMCD.membro_id = M.id
//                      LEFT JOIN cargos C
//                        ON AMCD.cargo_id = C.id
//                      WHERE AMCD.ativo = \'S\'
//                        AND C.empresa_id = ?
//                        AND C.id IN (' . $cargos . ')
//                      ORDER BY M.nome';
        } elseif ($tipo == 'S') {
            $arrCargos = self::getCargoSecretarioEmpresa();
            $cargos = '';
            foreach ($arrCargos as $value) {
                $cargos .= $value . ',';
            }
            $cargos = substr($cargos, 0, -1);
            $query = "SELECT mcd.*, m.nome, m.rg, m.cpf, c.nome cargo, c.abreviacao
                      FROM assoc_membros_cargos_departamentos mcd
                      INNER JOIN membros m
                        ON mcd.membro_id = m.id
                      INNER JOIN cargos c
                        ON mcd.cargo_id = c.id  
                      WHERE mcd.empresa_id = $empresa 
                        AND mcd.membro_id = $id
                        AND mcd.periodo = '$ano'
                        AND mcd.cargo_id IN ($cargos)    
                      ORDER BY mcd.periodo DESC, mcd.ativo DESC";
//            $query = "SELECT TBL.*
//                      FROM (SELECT M.cpf, M.id, M.nome, '1' ordem
//                            FROM assoc_membros_cargos_departamentos AMCD
//                            LEFT JOIN membros M
//                              ON AMCD.membro_id = M.id
//                            LEFT JOIN cargos C
//                              ON AMCD.cargo_id = C.id
//                            WHERE AMCD.ativo = 'S'
//                              AND C.empresa_id = ?
//                              AND C.id IN ($cargos)
//                            UNION
//                            SELECT M.cpf, M.id, M.nome, '2' ordem
//                            FROM membros M
//                            LEFT JOIN assoc_membros_cargos_departamentos AMCD
//                              ON AMCD.membro_id = M.id
//                            LEFT JOIN cargos C
//                              ON AMCD.cargo_id = C.id
//                            WHERE M.empresa_id = $empresa
//                              AND IFNULL(C.id,'0') NOT IN ($cargos)) TBL    
//                      ORDER BY TBL.ordem, TBL.nome";
        }
        $r = $c->query($query);
//        $com = $c->prepare($query);
//        $com->bind_param('i', $empresa);
//        $com->execute();
//        $r = $com->get_result();
        $retorno = [];
        while ($l = $r->fetch_assoc()) {
            $retorno[] = $l;
        }

        return $retorno;
    }

    public static function getCargoSecretarioEmpresa()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT id_secretarios_ata cargos
                      FROM parametros_sistema
                      WHERE empresa_id = $empresa ";
            $r = $c->query($query);
            $l = $r->fetch_assoc();
            $ret = explode(',', $l['cargos']);
            return $ret;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public static function getCargoPresidenteEmpresa()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT id_presidentes_ata cargos
                      FROM parametros_sistema
                      WHERE empresa_id = $empresa ";
            $r = $c->query($query);
            $l = $r->fetch_assoc();
            $ret = explode(',', $l['cargos']);
            return $ret;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function excluiMembroEmpresa()
    {
        try {
            if (!$this->id) {
                throw new \Exception('Membro não instanciado');
            }
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'DELETE
                      FROM assoc_membros_empresas
                      WHERE membro_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii", $this->id, $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function excluiMembroDepartamento()
    {
        try {
            if (!$this->id) {
                throw new \Exception('Membro não instanciado');
            }
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'DELETE
                      FROM assoc_membros_departamentos
                      WHERE membro_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii", $this->id, $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function excluiCargosDepartamentos()
    {
        try {
            if (!$this->id) {
                throw new \Exception('Membro não instanciado');
            }
            $c = My::con();
            $empresa = EMPRESA;
            $query = 'DELETE
                      FROM assoc_membros_cargos_departamentos
                      WHERE membro_id = ?
                        AND empresa_id = ?';
            $com = $c->prepare($query);
            $com->bind_param(
                "ii", $this->id, $empresa
            );
            $com->execute();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function gravaCargoDepartamento($cargo_id, $departamento_id, $periodo, $ativo)
    {
        try {
            $c = My::con();
            $query = "INSERT INTO assoc_membros_cargos_departamentos (membro_id, cargo_id, departamento_id, ativo, periodo, empresa_id, user_id, created, modified)
                                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $com = $c->prepare($query);
            $com->bind_param(
                "iiissiiss", $this->id, $cargo_id, $departamento_id, $ativo, $periodo, $this->empresa_id, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function alteraCargoDepartamento($cargo_id, $departamento_id, $periodo, $ativo)
    {
        try {
            $c = My::con();
            $query = "UPDATE assoc_membros_cargos_departamentos
                      SET ativo = ?
                         ,user_id = ?
                         ,modified = ?
                      WHERE cargo_id = ?
                        AND departamento_id = ?
                        AND periodo = ?
                        AND membro_id = ?
                        AND empresa_id = ?";
            $com = $c->prepare($query);
            $com->bind_param(
                "sisiisii", $ativo, $this->user_id, $this->modified, $cargo_id, $departamento_id, $periodo, $this->id, $this->empresa_id
            );
            $com->execute();
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function gravaMembroEmpresa()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "INSERT INTO assoc_membros_empresas (
                                                                  membro_id,
                                                                  empresa_ant_id,
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
                "iiiiss", $this->id, $this->igreja_anterior, $empresa, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function gravaMembroDepartamento()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "INSERT INTO assoc_membros_departamentos (
                                                                  membro_id,
                                                                  departamento_id,
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
                "iiiiss", $this->id, $this->departamento_id, $empresa, $this->user_id, $this->created, $this->modified
            );
            $com->execute();
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function gravaImagem()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (!$this->id) {
                throw new \Exception("Não existe registro para salvar esta imagem.");
            }
            $query = "UPDATE membros
                      SET foto = ?
                      WHERE id = ?
                        AND empresa_id = ?";
            $com = $c->prepare($query);
            $com->bind_param(
                "sii", $this->imagem, $this->id, $this->empresa_id
            );
            $com->execute();
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function getCargos()
    {
        try {
            $c = My::con();
            if ($this->id) {
                $query = "SELECT amc.membro_id
                            ,amc.cargo_id
                            ,amc.departamento_id
                            ,dep.nome departamento
                            ,car.nome cargo
                            ,amc.ativo
                            ,amc.periodo
                      FROM assoc_membros_cargos_departamentos amc
                      INNER JOIN membros mem
                          ON amc.membro_id = mem.id
                         AND amc.empresa_id = mem.empresa_id
                      INNER JOIN cargos car
                          ON amc.cargo_id = car.id
                         AND amc.empresa_id = car.empresa_id
                      INNER JOIN departamentos dep
                          ON amc.departamento_id = dep.id
                         AND amc.empresa_id = dep.empresa_id
                      WHERE amc.empresa_id = ?
                        AND amc.membro_id = ?
                      ORDER BY amc.ativo DESC
                              ,amc.periodo DESC";
                $com = $c->prepare($query);
                $com->bind_param(
                    "ii", $this->empresa_id, $this->id
                );
                $com->execute();
                $r = $com->get_result();
                $retorno = [];
                while ($l = $r->fetch_assoc()) {
                    $retorno[] = $l;
                }
                return $retorno;
            }
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public static function verificaCargosDepartamentos($cargo, $departamento, $ativo = 'S')
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT m.`nome`
                            ,c.`nome` cargo
                            ,d.`nome` departamento
                            ,mcd.`ativo`
                            ,mcd.`periodo`
                      FROM assoc_membros_cargos_departamentos mcd
                      LEFT JOIN membros m
                          ON mcd.`membro_id` = m.`id`
                         AND mcd.`empresa_id` = m.`empresa_id`
                      LEFT JOIN cargos c
                          ON mcd.`cargo_id` = c.`id`
                         AND mcd.`empresa_id` = c.`empresa_id`
                      LEFT JOIN departamentos d
                          ON mcd.`departamento_id` = d.`id`
                         AND mcd.`empresa_id` = d.`empresa_id`
                      WHERE mcd.`empresa_id` = ?
                        AND mcd.`cargo_id` = ?
                        AND mcd.`departamento_id` = ?
                        AND mcd.ativo = ?;";
            $com = $c->prepare($query);
            $com->bind_param(
                "iiis", $empresa, $cargo, $departamento, $ativo
            );
            $com->execute();
            $r = $com->get_result();
            $l = $r->fetch_assoc();
            return $l;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public static function getPresidenteEmpresa()
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT m.*
                      FROM membros m
                      INNER JOIN assoc_membros_cargos_departamentos mcd
                         ON m.id = mcd.membro_id
                        AND mcd.ativo = 'S'	
                      INNER JOIN cargos c
                         ON mcd.cargo_id = c.id
                      INNER JOIN departamentos d
                         ON mcd.departamento_id = d.id
                      WHERE m.empresa_id = $empresa
                        AND c.abreviacao LIKE 'presidente%'
                      ORDER BY mcd.periodo DESC, mcd.cargo_id";
            $r = $c->query($query);
            $l = $r->fetch_assoc();
            return $l;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public static function getCargosMembro($id, $ano = null)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            if (is_null($ano)) {
                $query = "SELECT mcd.*, m.nome, m.rg, m.cpf, c.nome cargo, c.abreviacao
                      FROM assoc_membros_cargos_departamentos mcd
                      INNER JOIN membros m
                        ON mcd.membro_id = m.id
                      INNER JOIN cargos c
                        ON mcd.cargo_id = c.id  
                      WHERE mcd.empresa_id = $empresa 
                        AND mcd.membro_id = $id
                        AND mcd.ativo = 'S'";
            } else {
                $query = "SELECT mcd.*, m.nome, m.rg, m.cpf, c.nome cargo, c.abreviacao
                      FROM assoc_membros_cargos_departamentos mcd
                      INNER JOIN membros m
                        ON mcd.membro_id = m.id
                      INNER JOIN cargos c
                        ON mcd.cargo_id = c.id  
                      WHERE mcd.empresa_id = $empresa 
                        AND mcd.membro_id = $id
                        AND mcd.periodo = '$ano'
                      ORDER BY mcd.periodo DESC, mcd.ativo DESC";
            }
            $r = $c->query($query);
            $retorno = [];
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public static function getMembrosByListaId($id_list)
    {
        try {
            $c = My::con();
            $empresa = EMPRESA;
            $query = "SELECT M.*, E.logradouro, E.bairro, E.localidade, E.cep, U.sigla
                      FROM membros M
                      LEFT JOIN enderecos E
                        ON M.enderecos_id = E.id
                      LEFT JOIN estados U
                        ON E.estado_id = U.id	
                      WHERE M.empresa_id = $empresa 
                        AND M.id in ($id_list)";
            $r = $c->query($query);
            while ($l = $r->fetch_assoc()) {
                $retorno[] = $l;
            }
            return $retorno;
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }
    }

    public function alteraFrequenciaMembro()
    {
        try {
            $c = My::con();
            if (!is_null($this->frequencia)) {
                $com = $c->prepare("UPDATE membros
                                           SET frequencia_id = ?
                                           WHERE id = ?
                                             AND empresa_id = ?");
                $com->bind_param(
                    "iii", $this->frequencia, $this->id, $this->empresa_id
                );
                $com->execute();
            }/* else {
              throw new \Exception('Sem vinculação DE PARA');
              } */
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
