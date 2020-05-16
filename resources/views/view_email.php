<?php


// If you installed via composer, just use this code to require autoloader on the top of your projects.
//ob_start();


require __DIR__ . '/../../vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;
use Mpdf\Mpdf;
use Dotenv\Dotenv;


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//$dotenv->load();


//$data = $database->query("")->fetchAll(PDO::FETCH_OBJ);


$data = $adjunto;

$extension = explode('/', mime_content_type($data))[1];

// We need to remove the "data:image/png;base64,"
$base_to_php = explode(',', $data);

// the 2nd item in the base_to_php array contains the content of the image
$data_save = base64_decode($base_to_php[1]);


$name_file = $idlpempleado.'_'.strtotime("now");

$path_file = "./adjuntos_incapacidades/$name_file.$extension";

file_put_contents("$path_file", $data_save);



$mail = new PHPMailer(true);



$pdo = new PDO('mysql:dbname='.getenv('DB_DATABASE').';host=127.0.0.1', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

$database = new Medoo([
	// Initialized and connected PDO object
	'pdo' => $pdo,

	// [optional] Medoo will have different handle method according to different database type
	'database_type' => 'mysql'
]);



$database->query("SET lc_time_names = 'es_MX';")->execute();

$data = $database->query("SELECT
*
FROM
gconfiguracion
")->fetchAll(PDO::FETCH_OBJ);

$email_send = $data[0]->emailsst;

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
    $mail->addAddress("$email_send");

    
    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz', 'name.gz');         // Add attachments
    $mail->addAttachment("$path_file");    // Optional name
    

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'REGISTRO INCAPACIDAD';

    $fechainicio_format =  date("t-m-Y", strtotime("$fechainicio"));
    $fechavencimiento_format =  date("t-m-Y", strtotime("$fechavencimiento"));

    $mail->Body   = "
    El empleado en misión $nombrecompleto 
    con el contrato  ".$info['idlpcontrato']."
    con la  empresa cliente  ".$info['empresa']."
    registró incapacidad de  $numerodias  DIAS 
    por $diagnostico del  $fechainicio_format  al $fechavencimiento_format  a traves del portal WEB.
    Soporte adjunto";
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

    print json_encode($mensaje); 
}


?>

<?php

$response = '
<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


        <link rel="stylesheet" href="bootstrap.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
        @media print {


            div.btn-print {

                visibility: hidden;

            }
        }

        </style>

    </head>

    <body>


        <div class="container">

            <div class="row">

                <div class="col-sm">
                    El empleado en misión <?php echo $nombrecompleto; ?>
                    con el contrato <?php echo $info[idlpcontrato]; ?>
                    con la empresa cliente <?php echo $info[empresa]; ?>
                    registró incapacidad de <?php echo $numerodias; ?> DIAS por
                    ENFERMEDAD GENERAL del 26 de Diciembre de 2019 al 31 de Diciembre de 2019 a traves del portal WEB.
                    Soporte adjunto
                </div>
                <div class="col-sm">
                    <img src="<?php echo $data; ?>"> </img>
                </div>

    </body>

</html> ';


?>