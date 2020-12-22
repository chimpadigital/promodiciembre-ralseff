<?php

require 'PHPMailerAutoload.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
// Debes editar las próximas dos líneas de código de acuerdo con tus preferencias
//$email_to = "sdesigncba@gmail.com";
//$email_to = "carlosdanielgutierrez@gmail.com";


// $email_to ="info@ralseff.com";

$name = $_POST['name'];
$area = $_POST['area'];
$wp = $_POST['wp'];
$msj = $_POST['consulta'];


$email_subject = "Consulta Ralseff agosto 2019";

// Aquí se deberían validar los datos ingresados por el usuario
if(!isset($_POST['name']) ||
!isset($_POST['area']) ||
!isset($_POST['wp']) ||
!isset($_POST['consulta'])) {

echo "<b>Ocurrió un error y el formulario no ha sido enviado. </b><br />";
echo "Por favor, vuelva atrás y verifique la información ingresada<br />";
die();
}

$email_message = "Detalles del formulario :\n\n";
$email_message .= "Nombre: " . $_POST['name'] . "\n";
$email_message .= "Número: " . $_POST['area'] . $_POST['wp'] ."\n";
$email_message .= "Mensaje: " . $_POST['consulta'] . "\n";
$email_message2 = "<h1>Detalles del formulario :</h1><br>";
$email_message2 .= "<p>Nombre: " . $_POST['name'] ."</p>";
$email_message2 .= "<p>Número: " . $_POST['area'] . $_POST['wp'] ."</p>";
$email_message2 .= "<p>Mensaje: " . $_POST['consulta'] ."</p>";

//inicio script grabar datos en csv
$fichero = 'cursoabril landing 2.txt';//nombre archivo ya creado
//crear linea de datos separado por coma
$fecha=date("d-m-Y");
$hora=date("H:i:s");
$linea = $fecha.";".$hora.";".$name.";".$area.";".$wp.";".$msj."\n";
//echo $linea;
// Escribir la linea en el fichero
file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
//fin grabar datos
// $message=$message.' local='.$local;
// $mail = new PHPMailer;
// $mail->isSMTP();

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';

$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'ralseffenvios@gmail.com';
$mail->Password = 'Ralseffenvio';
$mail->setFrom('ralseffenvios@gmail.com', 'ralseff');

$mail->addReplyTo('consultas@ralseff.com','ralseff');
$mail->addAddress('consultas@ralseff.com','ralseff');
// $mail->addCc('ralseff@chimpancedigital.com.ar','chimpance');
$mail->isHTML(true);
$mail->Subject = $email_subject;
$mail->Body    = $email_message2;
$mail->AltBody = $email_message;

$mail->CharSet = 'UTF-8';
if (!$mail->send()) {
    $mail_enviado=false;
    $mail_error .= 'Mailer Error: '.$mail->ErrorInfo;
} else {
    $mail_enviado=true;
    $mail_error='Mensaje Enviado, Gracias';
}
// Ahora se envía el e-mail usando la función mail() de PHP
//$headers = 'From: Ralseff <info@ralseff.com>' . "\r\n" .
//    'Reply-To: noreply@ralseff.com' . "\r\n" .
//    'Cc: ralseff@chimpancedigital.com.ar' . "\r\n" .
//    'X-Mailer: PHP/' . phpversion();
//$mail_enviado = @mail($email_to, utf8_decode($email_subject), utf8_decode($email_message), $headers);


if($mail_enviado)
{
echo "<script>location.href='../graciascurso';</script>";

}
else
{
	echo "no se pudo enviar" ;
}

// Envia un e-mail para el remitente, agradeciendo la visita en el sitio, y diciendo que en breve el e-mail sera respondido. 
// $mensaje2  = "Hola" . $_POST['name'] . ". Gracias por contactarnos. Un asesor se comunicará con usted a la brevedad..."; 
// $mensaje2 .= "PD - No es necesario responder este mensaje."; 
// $envia =  mail($_POST['email'],"Su mensaje fué recibido!",$mensaje2,$headers);



?>