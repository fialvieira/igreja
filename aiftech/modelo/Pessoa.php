<?php

namespace modelo;

use bd\My;

class Pessoa {

  const UF_AC = 'AC';
  const UF_AL = 'AL';
  const UF_AP = 'AP';
  const UF_AM = 'AM';
  const UF_BA = 'BA';
  const UF_CE = 'CE';
  const UF_DF = 'DF';
  const UF_ES = 'ES';
  const UF_GO = 'GO';
  const UF_MA = 'MA';
  const UF_MT = 'MT';
  const UF_MS = 'MS';
  const UF_MG = 'MG';
  const UF_PA = 'PA';
  const UF_PB = 'PB';
  const UF_PR = 'PR';
  const UF_PE = 'PE';
  const UF_PI = 'PI';
  const UF_RJ = 'RJ';
  const UF_RN = 'RN';
  const UF_RS = 'RS';
  const UF_RO = 'RO';
  const UF_RR = 'RR';
  const UF_SC = 'SC';
  const UF_SP = 'SP';
  const UF_SE = 'SE';
  const UF_TO = 'TO';
  const ESTADOS = [
      'AC' => 'ACRE',
      'AL' => 'ALAGOAS',
      'AP' => 'AMAPÁ',
      'AM' => 'AMAZONAS',
      'BA' => 'BAHIA',
      'DF' => 'DISTRITO FEDERAL',
      'ES' => 'ESPÍRITO SANTO',
      'GO' => 'GOIÁS',
      'MA' => 'MARANHÃO',
      'MT' => 'MATO GROSSO',
      'MS' => 'MATO GROSSO DO SUL',
      'MG' => 'MINAS GERAIS',
      'PA' => 'PARÁ',
      'PB' => 'PARAÍBA',
      'PA' => 'PARANÁ',
      'PE' => 'PERNAMBUCO',
      'PI' => 'PIAUÍ',
      'RJ' => 'RIO DE JANEIRO',
      'RN' => 'RIO GRANDE DO NORTE',
      'RS' => 'RIO GRANDE DO SUL',
      'RP' => 'RONDÔNIA',
      'RR' => 'RORAIMA',
      'SC' => 'SANTA CATARINA',
      'SP' => 'SÃO PAULO',
      'SE' => 'SERGIPE',
      'TO' => 'TOCANTINS'
  ];
  const SEXO_M = 'M';
  const SEXO_F = 'F';
  const SEXO_O = 'O';
  const SEXOS = [
      'M' => 'Masculino',
      'F' => 'Feminino',
      'O' => 'Outros'
  ];
  
  private $codigo;
  private $nome;
  private $cpf;
  private $rg;
  private $email;
  private $telefone;
  private $celular;
  private $nascimento;
  private $sexo;
  private $endereco;
  private $bairro;
  private $cidade;
  private $uf;
  private $cep;

  /**
   * Usuario constructor.
   * @param $codigo
   * @throws \Exception
   */
  public function __construct($cpf) {
    if ($cpf) {
      $cpf = \bd\Formatos::cpfBd($cpf);
      $c = My::con();
      $r = $c->query("CALL pessoa_seleciona($cpf)");
      $l = $r->fetch_assoc();
      if ($l) {
        $this->nome = $l['nome'];
        $this->cpf = $cpf;
        $this->rg = $l['rg'];
        $this->email = $l['email'];
        $this->telefone = $l['telefone'];
        $this->celular = $l['celular'];
        $this->nascimento = $l['nascimento'];
        $this->sexo = $l['sexo'];
        $this->endereco = $l['endereco'];
        $this->bairro = $l['bairro'];
        $this->cidade = $l['cidade'];
        $this->uf = $l['uf'];
        $this->cep = $l['cep'];
        $this->codigo = $l['codigo'];
      }else{
        $this->cpf = $cpf;
      }
      $c->next_result();
    }
  }

  /**
   * @return mixed
   */
  public function getCodigo() {
    return $this->codigo;
  }

  /**
   * @param mixed $codigo
   */
  public function setCodigo($codigo) {
    $this->codigo = $codigo;
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
  public function getEmail() {
    return $this->email;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  public function getTelefone() {
    return \bd\Formatos::telefoneApp($this->telefone);
  }

  public function setTelefone($telefone) {
    $this->telefone = \bd\Formatos::telefoneBd($telefone);
  }
  
  public function getCelular() {
    return \bd\Formatos::telefoneApp($this->celular);
  }

  public function setCelular($celular) {
    $this->celular = \bd\Formatos::telefoneBd($celular);
  }
  
  public function getNascimento() {
    return \bd\Formatos::dataApp($this->nascimento);
  }

  public function setNascimento($nascimento) {
    $this->nascimento = \bd\Formatos::dataBd($nascimento);
  }
  
  public function getSexo() {
    return $this->sexo;
  }

  public function setSexo($sexo) {
    $this->sexo = $sexo;
  }
  
  public function getCpf() {
    return \bd\Formatos::cpfApp($this->cpf);
  }

  public function setCpf($cpf) {
    $this->cpf = \bd\Formatos::cpfBd($cpf);
  }

  public function getRg() {
    return $this->rg;
  }

  public function setRg($rg) {
    $this->rg = $rg;
  }

  public function getEndereco() {
    return $this->endereco;
  }

  public function setEndereco($endereco) {
    $this->endereco = $endereco;
  }

  public function getBairro() {
    return $this->bairro;
  }

  public function setBairro($bairro) {
    $this->bairro = $bairro;
  }

  public function getCidade() {
    return $this->cidade;
  }

  public function setCidade($cidade) {
    $this->cidade = $cidade;
  }

  public function getUf() {
    return $this->uf;
  }

  public function setUf($uf) {
    $this->uf = $uf;
  }

  public function getCep() {
    return \bd\Formatos::cepApp($this->cep);
  }

  public function setCep($cep) {
    $this->cep = \bd\Formatos::cepBd($cep);
  }

  public function salva() {
    $c = My::con();
    if (!$this->nome) {
      throw new \Exception('Nome obrigatório.');
    }
    if (!$this->cpf) {
      throw new \Exception('CPF obrigatório.');
    }
    if ($this->codigo) {
      $com = $c->prepare('CALL pessoa_altera(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $com->bind_param(
              'sssssssssssssi', $this->nome, $this->cpf, $this->rg, $this->email, $this->telefone, $this->celular, 
              $this->nascimento, $this->sexo, $this->endereco, $this->bairro, $this->cidade, $this->uf, $this->cep, $this->codigo
      );
      $com->execute();
    } else {
      $com = $c->prepare('CALL pessoa_insere(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $com->bind_param(
              'sssssssssssss', $this->nome, $this->cpf, $this->rg, $this->email, $this->telefone, $this->celular, 
              $this->nascimento, $this->sexo, $this->endereco, $this->bairro, $this->cidade, $this->uf, $this->cep
      );
      $com->execute();
      $r = $com->get_result();
      $l = $r->fetch_assoc();
      $this->codigo = $l['id'];
      $c->next_result();
    }
  }

  public static function seleciona() {
    $c = My::con();
    $r = $c->query('CALL pessoas_seleciona()');
    $pessoas = [];
    while ($l = $r->fetch_assoc()) {
      $pessoas[] = $l;
    }
    $c->next_result();
    return $pessoas;
  }

}
