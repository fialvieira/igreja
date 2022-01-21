<?php

use PHPMailer\PHPMailer\PHPMailer;

function autoload($classe)
{
    $classe = str_replace('\\', '/', $classe);
    $possiveisPastas = [
        RAIZ . 'core/',
        RAIZ,
    ];
    foreach ($possiveisPastas as $possivelPasta) {
        $arquivo = $possivelPasta . $classe . '.php';
        if (file_exists($arquivo)) {
            include $arquivo;
        }
    }
}

function conf($configuracao)
{
    $arquivo = RAIZ . 'conf/' . $configuracao . '.php';
    if (!file_exists($arquivo)) {
        throw new \Exception('Configuração ' . $configuracao . ' inexistente.');
    }
    return include($arquivo);
}

function d($array)
{
    echo '<br><pre class="printr">';
    print_r($array);
    echo '</pre>';
}

function dd($dados)
{
    d($dados);
    exit;
}

function e($txt)
{
    return htmlentities($txt, ENT_QUOTES, 'UTF-8');
}

function hs($txt)
{
    return htmlspecialchars($txt, ENT_COMPAT);
}

function idade($data)
{
    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    return $idade;
}

function convertNumToWords($number)
{
    $hyphen = '-';
    $conjunction = ' e ';
    $separator = ', ';
    $negative = 'menos ';
    $decimal = ' ponto ';
    $dictionary = array(
        0 => 'zero',
        1 => 'um',
        2 => 'dois',
        3 => 'três',
        4 => 'quatro',
        5 => 'cinco',
        6 => 'seis',
        7 => 'sete',
        8 => 'oito',
        9 => 'nove',
        10 => 'dez',
        11 => 'onze',
        12 => 'doze',
        13 => 'treze',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'dezesseis',
        17 => 'dezessete',
        18 => 'dezoito',
        19 => 'dezenove',
        20 => 'vinte',
        30 => 'trinta',
        40 => 'quarenta',
        50 => 'cinquenta',
        60 => 'sessenta',
        70 => 'setenta',
        80 => 'oitenta',
        90 => 'noventa',
        100 => 'cento',
        200 => 'duzentos',
        300 => 'trezentos',
        400 => 'quatrocentos',
        500 => 'quinhentos',
        600 => 'seiscentos',
        700 => 'setecentos',
        800 => 'oitocentos',
        900 => 'novecentos',
        1000 => 'mil',
        1000000 => array('milhão', 'milhões'),
        1000000000 => array('bilhão', 'bilhões'),
        1000000000000 => array('trilhão', 'trilhões'),
        1000000000000000 => array('quatrilhão', 'quatrilhões'),
        1000000000000000000 => array('quinquilhão', 'quinquilhões')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convertNumToWords só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = floor($number / 100) * 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . convertNumToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = convertNumToWords($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = convertNumToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = convertNumToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string)$fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function mesPorExtenso($mes = null)
{
    if (!is_null($mes)) {
        $mes = intval($mes);
    }
    $dictionary = array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    );
    if (is_null($mes)) {
        return $dictionary;
    } else {
        return $dictionary[$mes];
    }
}

/**
 * @param $palavra
 * @return string|string[]|null
 */
function tiraAcentos($palavra)
{
    $nome = preg_replace(array(
        "/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/",
        "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/",
        "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/",
        "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/",
        "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/",
        "/(ç)/", "/(Ç)/",
        "/(ñ)/", "/(Ñ)/",
        "(º|°)",
        "(ª)"
    ), explode(" ", "a A e E i I o O u U c C n N o a"), $palavra);
    return $nome;
}

/**
 * @param $path
 * @return false|string
 * @throws Exception
 */
function nomeArquivo($path)
{
    try {
        if (is_null($path) || $path == '' || empty($path)) {
            throw new Exception('Variável PATH não definida.');
        }
        $inicio = strrpos($path, "/");
        return substr($path, $inicio + 1);;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

/**
 * Função que checa se a data passada por parâmetro é fim de semana
 * @param $data
 * @return bool
 * @throws Exception
 */
function isWeekend($data) {
    try {
        if (is_null($data) || $data == '' || empty($data)) {
            throw new Exception('Variável DATA não definida.');
        }
        if (( date('w', strtotime($data)) % 6 ) == 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

/**
 * Função para enivar e-mail pelo sistema
 * @param string $assunto Assunto do e-mail
 * @param string $mensagemHTML Mensagem do corpo do e-mail em formato HTML
 * @param string $email_de E-mail do remetente, de quem esta enviando
 * @param string $nome_de Nome do remetente, de quem esta enviando
 * @param string $email_para E-mail do destinatário, de quem irá receber
 * @param string $nome_para Nome do destinatário, de quem irá receber
 * @param string $msg_erro Mensagem de erro que o sistema irá apresentar caso ocorra alguma falha no envio.
 */
function enviaEmail($assunto, $mensagemHTML, $email_de, $nome_de, $email_para, $nome_para, $msg_erro)
{
//Create a new PHPMailer instance
    $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
    $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;
//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "aiftechbru@gmail.com";
//Password to use for SMTP authentication
    $mail->Password = "fusion22";
//Set who the message is to be sent from
    $mail->setFrom($email_de, $nome_de);
//Set an alternative reply-to address
//    $mail->addReplyTo($email_de, $nome_de);

//$mail->addBCC('aiftechbru@gmail.com', 'AIFTech');
//Set who the message is to be sent to
    $mail->addAddress($email_para, $nome_para);
//Set the subject line
    $mail->Subject = $assunto;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($mensagemHTML, __DIR__);
//Replace the plain text body with one created manually
    $mail->AltBody = '';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors

    if (!$mail->send()) {
        throw new \Exception($msg_erro . $mail->ErrorInfo);
    }
}
