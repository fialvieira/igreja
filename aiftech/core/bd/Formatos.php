<?php

namespace bd;

class Formatos {

    public static function nome($nome) {
        if ($nome) {
            if (mb_strlen($nome) < 3) {
                throw new \Exception('Formato de nome deve conter ao menos 3 caracteres.');
            }
            $nome = preg_replace('/\s+/', ' ', $nome);
            return strtoupper(tiraAcentos($nome));
        }
    }

    public static function email($email) {
        if ($email) {
            if (!preg_match('/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9.\-_]+(\.[a-zA-Z.\-_]+)?$/', $email)) {
                throw new \Exception('Formato de e-mail inválido');
            }
            return mb_strtolower($email);
        }
    }

    public static function inteiro($numero) {
        if ($numero) {
            if ($numero !== null) {
                if (is_numeric($numero)) {
                    return intval($numero);
                } else {
                    throw new \Exception('Formato inteiro inválido.');
                }
            }
        }
    }

    /**
     * @param $texto
     * @return string|null
     */
    public static function ft($texto) {
        if ($texto === null || $texto === '') {
            return null;
        }
        $palavras = explode(' ', trim_all($texto));
        $palavras_modificadas = [];
        foreach ($palavras as $p) {
            if (!is_null($p) && $p != '') {
                $palavras_modificadas[] = '+' . $p . '*';
            }
        }
        return str_replace(['.', '-'], '', implode(' ', $palavras_modificadas));
    }

    /**
     * Transforma número em string no formato de moeda para App (0.000,00) 
     * @param $numero float|int
     * @return string|null Valor no formato 0.000,00
     */
    public static function moeda($numero) {
        if ($numero !== null) {
            return number_format(self::real($numero), 2, ',', '.');
        }
    }

    /**
     * Transforma string em número no formato para BD (0000.00)
     * @param $numero string Valor no formato 0.000,00
     * @return float|null
     */
    public static function real($numero) {
        if ($numero !== null && $numero !== '') {
            if (!is_numeric($numero)) {
                $numero = str_replace(['.', ','], ['', '.'], $numero);
            }
            return (float) $numero;
        }
        return null;
    }

    public static function telefoneApp($telefone) {
        if ($telefone) {
            if (preg_match('/^(\(?[0-9?]{2}\)?)?[0-9]{3,5}\-?[0-9]{4}$/', $telefone)) {
                $telefone = str_replace(['(', ')', '-'], '', $telefone);
                switch (strlen($telefone)) {
                    case 11:
                        return '(' . substr($telefone, 0, 2) . ')' .
                                substr($telefone, 2, 5) . '-' .
                                substr($telefone, 7, 4);
                    case 10:
                        //DDD + 8 dígitos
                        return '(' . substr($telefone, 0, 2) . ')' .
                                substr($telefone, 2, 4) . '-' .
                                substr($telefone, 6);
                    case 9:
                        //9 dígitos                        
                        return substr($telefone, 0, 5) . '-' . substr($telefone, 5);
                    case 8:
                        //8 dígitos
                        return substr($telefone, 0, 4) . '-' . substr($telefone, 4);
                    default:
                        throw new \Exception('Formato de telefone inválido. (2)');
                }
            } else {
                throw new \Exception('Formato de telefone inválido.');
            }
        }
    }

    public static function telefoneBd($telefone) {
        if ($telefone) {
            if (preg_match('/^(\(?[0-9?]{2}\)?)?[0-9]{3,5}\-?[0-9]{4}$/', $telefone)) {
                return str_replace(['(', ')', '-'], '', $telefone);
            } else {
                throw new \Exception('Formato de telefone inválido.');
            }
        }
    }

    public static function cpfApp($cpf) {
        if ($cpf) {
            if (preg_match('/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/', $cpf)) {
                $cpf = str_replace(['.', '-'], '', $cpf);
                return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);
            } else {
                throw new \Exception('Formato de CPF inválido.');
            }
        }
    }

    public static function cpfBd($cpf) {
        if ($cpf) {
            if (preg_match('/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/', $cpf)) {
                return str_replace(['.', '-'], '', $cpf);
            } else {
                throw new \Exception('Formato de CPF inválido.');
            }
        }
    }

    public static function cepApp($cep) {
        if ($cep) {
            if (preg_match('/^[0-9]{5}\-?[0-9]{3}$/', $cep)) {
                $cep = str_replace('-', '', $cep);
                return substr($cep, 0, 5) . '-' . substr($cep, -3);
            } else {
                throw new \Exception('Formato de CEP inválido.');
            }
        }
    }

    public static function cepBd($cep) {
        if ($cep) {
            if (preg_match('/^[0-9]{5}\-?[0-9]{3}$/', $cep)) {
                return str_replace('-', '', $cep);
            } else {
                throw new \Exception('Formato de CEP inválido.');
            }
        }
    }

    public static function dataApp($data) {
        if ($data) {
            if (gettype($data) == 'string') {
                $data = substr($data, 0, 10);
                if (strpos($data, '/') !== false) {
                    $formato = 'd/m/Y';
                } else {
                    $formato = 'Y-m-d';
                }
                $d = \DateTime::createFromFormat($formato, $data);
                if ($d && $d->format($formato) == $data) {
                    return $d->format('d/m/Y');
                } else {
                    throw new \Exception('Formato de data inválido.');
                }
            } elseif (is_object($data) && get_class($data) == 'DateTime') {
                return $data->format('d/m/Y');
            }
            throw new \Exception('Formato de data inválido.');
        }
    }

    public static function dataBd($data) {
        if ($data) {
            if (gettype($data) == 'string') {
                if (strpos($data, '/') !== false) {
                    $formato = 'd/m/Y';
                } else {
                    $formato = 'Y-m-d';
                }
                $d = \DateTime::createFromFormat($formato, $data, new \DateTimeZone('UTC'));
                if ($d && $d->format($formato) == $data) {
                    return $d->format('Y-m-d');
                } else {
                    throw new \Exception('Formato de data inválido.');
                }
            } elseif (is_object($data) && get_class($data) == 'DateTime') {
                return $data->format('Y-m-d');
            }
            throw new \Exception('Formato de data inválido.');
        }
    }

    public static function dataHoraBd($dataHora) {
        if ($dataHora) {
            if (is_string($dataHora)) {
                $dataHora = substr($dataHora, 0, 19);
                if (strpos($dataHora, '/') !== false) {
                    $formato = 'd/m/Y H:i:s';
                } else {
                    $formato = 'Y-m-d H:i:s';
                }
                $d = \DateTime::createFromFormat($formato, $dataHora, new \DateTimeZone('UTC'));
                if ($d && $d->format($formato) == $dataHora) {
                    return $d->format('Y-m-d H:i:s');
                } else {
                    throw new \Exception('Formato de data inválido.');
                }
            } elseif (is_object($dataHora) && get_class($dataHora) == 'DateTime') {
                return $dataHora->format('Y-m-d H:i:s');
            }
            throw new \Exception('Formato de data/hora inválido.');
        }
    }

    public static function dataHoraApp($dataHora) {
        if ($dataHora) {
            if (is_string($dataHora)) {
                $dataHora = substr($dataHora, 0, 19);
                if (strpos($dataHora, '/') !== false) {
                    $formato = 'd/m/Y H:i:s';
                } else {
                    $formato = 'Y-m-d H:i:s';
                }
                $d = \DateTime::createFromFormat($formato, $dataHora);
                if ($d && $d->format($formato) == $dataHora) {
                    return $d->format('d/m/Y H:i:s');
                } else {
                    throw new \Exception('Formato de data inválido.');
                }
            } elseif (is_object($dataHora) && get_class($dataHora) == 'DateTime') {
                return $dataHora->format('d/m/Y H:i:s');
            }
            throw new \Exception('Formato de data/hora inválido.');
        }
    }

    public static function mcuApp($mcu) {
        $mcu = trim($mcu);
        if (preg_match('/^[0-9]{8}$/', $mcu)) {
            return $mcu;
        } else {
            throw new \Exception('Formato de MCU inválido.');
        }
    }

    public static function mcuBd($mcu) {
        $mcu = trim($mcu);
        if (preg_match('/^[0-9]{8}$/', $mcu)) {
            return '    ' . $mcu;
        } else {
            throw new \Exception('Formato de MCU inválido.');
        }
    }

    public static function cnpjApp($cnpj) {
        if ($cnpj) {
            $regex = '/^[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}-?[0-9]{2}$/';
            if (preg_match($regex, $cnpj)) {
                $cnpj = str_replace(['.', '/', '-'], '', $cnpj);
                return substr($cnpj, 0, 2) . '.' .
                        substr($cnpj, 2, 3) . '.' .
                        substr($cnpj, 5, 3) . '/' .
                        substr($cnpj, 8, 4) . '-' .
                        substr($cnpj, 12);
            } else {
                throw new \Exception('Formato de CNPJ inválido.');
            }
        }
    }

    public static function cnpjBd($cnpj) {
        //74.787.271/0001-75
        if ($cnpj) {
            $regex = '/^[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}-?[0-9]{2}$/';
            if (preg_match($regex, $cnpj)) {
                return str_replace(['.', '/', '-'], '', $cnpj);
            } else {
                throw new \Exception('Formato de CNPJ inválido.');
            }
        }
    }

    public static function placaApp($placa) {
        if ($placa) {
            $placa = trim($placa);
            if (preg_match('/^[a-zA-Z]{3}\-?[0-9]{4}$/', $placa)) {
                $placa = str_replace('-', '', $placa);
                $placa = upper($placa);
                return substr($placa, 0, 3) . '-' . substr($placa, 3);
            } else {
                throw new \Exception('Formato de placa de veículo inválido.');
            }
        }
    }

    public static function placaBd($placa) {
        if ($placa) {
            $placa = trim($placa);
            if (preg_match('/^[a-zA-Z]{3}\-?[0-9]{4}$/', $placa)) {
                $placa = str_replace('-', '', $placa);
                return upper($placa);
            } else {
                throw new \Exception('Formato de placa de veículo inválido.');
            }
        }
    }

}
