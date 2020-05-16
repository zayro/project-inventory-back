<?php

require __DIR__ . '/../../../vendor/autoload.php';

//use PDO;

use Medoo\Medoo;
use Mpdf\Mpdf;
use Dotenv\Dotenv;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Hash;

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.socketlabs.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'server23771';                     // SMTP username
    $mail->Password   = 'Cw97YtNs6j8DKo3';                               // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('webmaster@genteutil.net', 'Enviado');
    //$mail->addAddress('zayro8905@gmail.com', 'Marlon Zayro');
    $mail->addAddress("$email");

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Recuperar Password';

    $mail->Body   = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>correo</title>
    </head>
    <body>
        <p>Nuevo Password: $newpass </p>
        
    </body>
    </html>";


    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    $mensaje = [];
    $mensaje['success'] = true;
    $mensaje['msj'] = "se ha enviado un correo $email";

    print json_encode($mensaje);
} catch (Exception $e) {
    $mensaje = [];
    $mensaje['success'] = false;
    $mensaje['email'] = $email;
    $mensaje['msj'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    Log::info('error enviando mensaje: '.$newpass);

    print json_encode($mensaje);
    
    /**
     * ENVIAR CORREO
     */

    $para = "$email";

    $titulo = 'Recuperar Password';

    $mensaje = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>correo</title>
    </head>
    <body>
        <p>Nuevo Password: $newpass </p>
        
    </body>
    </html>";

    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From: webmaster@genteutil.net';

    $enviado = mail($para, $titulo, $mensaje, $cabeceras);

    //$enviado = true;

    if ($enviado) {
        //echo 'Email enviado correctamente';

        //Log::info('envio email');

        try {
            $dsn = "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_DATABASE');
            $dbh = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $newpassword = Hash::make($newpass);
            $count = $dbh->exec("UPDATE users set `password` = '$newpassword' where email =  '$email' ");

            print("UPDATE $count rows.\n");
        } catch (PDOException $e) {
            $mensaje = [];
            //$mensaje['sql'] = $sql;
            $mensaje['request'] = $_REQUEST;
            $mensaje['success'] = false;
            $mensaje['msj'] = 'ERROR: PDOException' . $e->getMessage();
        
            Log::error($e->getMessage());
        } catch (Exception $e) {
            $mensaje = [];
            //$mensaje['sql'] = $sql;
            $mensaje['request'] = $_REQUEST;
            $mensaje['success'] = false;
            $mensaje['msj'] = 'ERROR: Exception' . $e->getMessage();
        
            Log::error($e->getMessage());
        } catch (Throwable $e) {
            $mensaje = [];
            //$mensaje['sql'] = $sql;
            $mensaje['request'] = $_REQUEST;
            $mensaje['success'] = false;
            $mensaje['msj'] = 'ERROR: Throwable' . $e->getMessage();
        
            Log::error($e->getMessage());
        }
    } else {
        echo 'Error en el envío del email';
    }
}
