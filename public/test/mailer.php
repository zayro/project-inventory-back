<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Load Composer's autoloader
 //require '../vendor/autoload.php';
 require __DIR__ . '/../../vendor/autoload.php';

//instancio un objeto de la clase PHPMailer
$mail = new PHPMailer(); // defaults to using php "mail()"


//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;

//defino el email y nombre del remitente del mensaje
$mail­->SetFrom('zayro8905@gmail.com', 'Nombre completo');


//Defino la dirección de correo a la que se envía el mensaje
$address = "zarias@formasestrategicas.com.co";
//la añado a la clase, indicando el nombre de la persona destinatario
$mail-­>AddAddress($address, "Nombre completo");

//Añado un asunto al mensaje
$mail­->Subject = "Envío de email con PHPMailer en PHP";


$body = "mensaje de prueba";

//inserto el texto del mensaje en formato HTML
$mail­->MsgHTML($body);

//envío el mensaje, comprobando si se envió correctamente
if(!$mail­->Send()) {
echo "Error al enviar el mensaje: " . $mail-­>ErrorInfo;
} else {
echo "Mensaje enviado!!";
}