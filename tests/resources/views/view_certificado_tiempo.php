<?php


// If you installed via composer, just use this code to require autoloader on the top of your projects.
//ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';


date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_ES");


// Using Medoo namespace
use Medoo\Medoo;
use Mpdf\Mpdf;
use Dotenv\Dotenv;

//$dotenv->load();

$pdo = new PDO('mysql:dbname='.getenv('DB_DATABASE').';host=127.0.0.1', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

$database = new Medoo([
	// Initialized and connected PDO object
	'pdo' => $pdo,

	// [optional] Medoo will have different handle method according to different database type
	'database_type' => 'mysql'
]);



$database->query("SET lc_time_names = 'es_MX';")->execute();

$data = $database->query("SELECT
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.tipodocumento,
vlpcontratos_empleados.idlpcontrato,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.fechaingreso,
YEAR(vlpcontratos_empleados.fechaingreso) anualidad_ingreso,
MONTHNAME(vlpcontratos_empleados.fechaingreso) mes_ingreso,
DAY(vlpcontratos_empleados.fechaingreso) dia_ingreso,
vlpcontratos_empleados.fecharetiro,
YEAR(vlpcontratos_empleados.fecharetiro) anualidad_retiro,
MONTHNAME(vlpcontratos_empleados.fecharetiro) mes_retiro,
DAY(vlpcontratos_empleados.fecharetiro) dia_retiro,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.salario promedio,
vlpcontratos_empleados.salario noprestacional,
vlpcontratos_empleados.numerohoras,
vlpcontratos_empleados.numerohoras diaslaborados,
vlpcontratos_empleados.salario valor_variable,
vlpcontratos_empleados.salario prestacional,
vlpcontratos_empleados.idlpestadoscontratos,
vlpcontratos_empleados.idempresas idempresas
from
vlpcontratos_empleados
where
vlpcontratos_empleados.idlpcontrato = '$idlpcontrato'
and vlpcontratos_empleados.idlpestadoscontratos in (2,	3,	4,	6)
")->fetchAll(PDO::FETCH_OBJ);



?>



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
        p.text-sm-left {
            margin-bottom: 0px;
        }

        @media screen {

            /* Contenido del fichero home.css */
            p,
            h1,
            h3 {
                margin: 0 auto;
            }

        }

        @media print {

            /* Contenido del fichero print.css */
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
                    <div class="text-left">
                        <img src="./assets/images/logo_gu.png" width="190" height="57" alt="...">
                    </div>

                </div>

            </div>


            <div class="row">
                <div class="col-sm">
                    <h1 class="text-center">
                        <p>CERTIFICAMOS QUE</p>
                        <br>

                    </h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <h1 class="text-center">
                        <p><?php print $data[0]->nombrecompleto; ?></p>
                        <br>

                    </h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <h3 class="text-center">TRABAJADOR EN MISION</h3>
                    <br>
            </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="text-just">
                        <p>Identificado(a) con cedula de ciudadanìa <?php print $data[0]->nroidentificacion; ?> ha laborado
                            mediante contrato de trabajo por el termino que dure la obra o labor determinada en nuestra empresa usuaria: </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <br>
                    <h1 class="text-center"><?php print $data[0]->empresa; ?></h1>
                    <br>
                </div>
            </div>


            <div class="row ">
                <div class="col-sm">
                    <div class="text-just">
                        <p>Desempeñando la misiòn de <?php print $data[0]->cargo; ?> siendo las fechas de vinculacion
                            del <?php print $data[0]->dia_ingreso; ?> de  <?php print $data[0]->mes_ingreso; ?> del <?php print $data[0]->anualidad_ingreso; ?>

                            <?php if($data[0]->fecharetiro != null ||$data[0]->fecharetiro != '' ) { ?>
                                al <?php print $data[0]->dia_retiro; ?> de  <?php print $data[0]->mes_retiro ?> del <?php print $data[0]->anualidad_retiro; ?>
                            <?php } else { ?>

                                vigente a la fecha


                            <?php } ?>



                            </p>
                    </div>

                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">

                    <div class="text-just">
                        <p> Se expide en Bucaramanga a los <?php print date('d'); ?> dias del mes <?php print date('F'); ?> de <?php print date('Y'); ?>  </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">

                    <div class="text-left">
                        <br>
                        <br>
                        <p> Coordialmente </p>
                        <br>
                        <img src="./assets/images/firma_certgu.jpg" alt="firma">
                        <br>
                        <P>YOLANDA ORTIZ VASQUEZ</P>
                        <P>GERENTE COMERCIAL</P>
                    </div>
                </div>
            </div>




            <div class="row btn-print">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.print();"> Imprimir
                    Documento </button>

            </div>

        </div>



    </body>


</html>
