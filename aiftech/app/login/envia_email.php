<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

require_once RAIZ . 'vendor/autoload.php';

$nome = $usuario->getNome();
$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s');
$assunto = $empresa->getNome().' - Redefinição de senha.';
$mensagemHTML = "
    <html>
        <div style='text-align:justify;width:80%'>
          <br>
          <p>Olá $nome</p>
          <p>Em $data_envio às $hora_envio, foi realizado uma solicitação para redefinir a sua senha utilizada no site " . SITE . "app/index.php.</p>
          <p>Use <a style='color:#39f' href='$link' target='_blank'>este link</a> para cadastrar uma nova senha.</p>
          <p style='margin-bottom:0px;padding-bottom:0px;font-weight:bold'>Obrigado,</p>
          <p style='margin-top:0px;padding-top:0px;font-weight:bold'>Equipe AIFTech</p>
          <p style='margin-top:0px;padding-top:0px;font-size:10px'>Gentileza não responder este e-mail.</p>
          <p style='font-size:10px'>Caso esta solicitação não tenha sido feita por você ou se acredita que outra pessoa não autorizada esta tentando acessar sua conta, comunique-se com o Centro de Atendimento AIFTech através do e-mail <a href='mail:aiftechbru@gmail.com' target='_blank'>aiftechbru@gmail.com</a>.</p> 
        </div>
    </html>
  ";


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
$mail->setFrom($empresa->getEmail(), $empresa->getNome());
//Set an alternative reply-to address
$mail->addReplyTo($empresa->getEmail(), $empresa->getNome());
$mail->addBCC('aiftechbru@gmail.com', 'AIFTech');
//Set who the message is to be sent to
$mail->addAddress($email, $nome);
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
    throw new \Exception('Erro ao enviar o e-mail. Error: ' . $mail->ErrorInfo);
}
