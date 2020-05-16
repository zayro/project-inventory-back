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
and vlpcontratos_empleados.idlpestadoscontratos = 2
")->fetchAll(PDO::FETCH_OBJ);

$query_salario_promedio = "SELECT
	lpdetallenomina.idlpcontrato,
	lpsubtiponovedad.tipoacumulado,
	lpnovedades.tipo,
	sum(lpdetallenomina.valor) valor,
	sum(lpdetallenomina.numerodias) numerodias,
	sum(lpdetallenomina.numerohoras) numerohoras
from
	lpdetallenomina
inner join lpnovedades on
	lpdetallenomina.idlpnovedades = lpnovedades.idlpnovedades
inner join lpsubtiponovedad on
	lpnovedades.idlpsubtiponovedad = lpsubtiponovedad.idlpsubtiponovedad
where
	lpdetallenomina.idlpcontrato = '$idlpcontrato'
	and lpsubtiponovedad.tipoacumulado > 0
	and lpdetallenomina.anulado = 0
group by
	lpsubtiponovedad.tipoacumulado";

$salario_promedio = $database->query($query_salario_promedio);

$lnAcumuladoPrest = 0;
$lnAcumuladosNoPrest = 0;
$lnAcumuladoPromedioVariable = 0;

while($row = $salario_promedio->fetch(PDO::FETCH_OBJ)){

    if($row->tipoacumulado == 1 || $row->tipoacumulado == 2 || $row->tipoacumulado == 4 || $row->tipoacumulado == 6 ||  $row->tipoacumulado == 7 || $row->tipoacumulado == 13  ){

        $lnAcumuladoPrest += $row->valor;
        /*
        print '<br>';
        print " tipo : $row->tipoacumulado y valor $row->valor  ";
        print '<br>';
        print 'lnAcumuladoPrest: '. $lnAcumuladoPrest;
        print '<br>';
        */
    }

    if($row->tipoacumulado == 6 ||  $row->tipoacumulado == 7 || $row->tipoacumulado == 13  ){
        $lnAcumuladoPromedioVariable += $row->valor;
    }

    if($row->tipoacumulado == 8 ){
        $lnAcumuladosNoPrest = $row->valor;
    }
}


$lndias_lab = "";
$lndias_actual = "";

if($data[0]->fecharetiro == null || $data[0]->fecharetiro == '0000-00-00') {

    $lndias_actual = date("Y-m-d");

} else {
    $lndias_actual == $data[0]->fecharetiro;
}

/*
$lndias_lab = (strtotime($lndias_actual) - strtotime($data[0]->fechaingreso)) + 1;

$diff = abs(strtotime($lndias_actual) - strtotime($data[0]->fechaingreso));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


print '<br>';
echo "Difference between two dates: " . (strtotime($lndias_actual)  - strtotime($data[0]->fechaingreso))/60/60/24;
print '<br>';

print '<br>';
printf("%d years, %d months, %d days\n", $years, $months, $days);
print '<br>';

print "FECHA ACTUAL:  ".$lndias_actual;
print '<br>';
print "FECHA INGRESO:  ".$data[0]->fechaingreso;
print '<br>';
print "DIFERENCIA ACTUAL A INGRESO:  ". date("d", $lndias_lab); ;
print '<br>';

*/


$lndias_lab = ((strtotime($lndias_actual)  - strtotime($data[0]->fechaingreso))/60/60/24)+1;

$lnPromedioNoprest = round((($lnAcumuladosNoPrest / $lndias_lab) * 30));

$lnPromedio = round((($lnAcumuladoPrest/$lndias_lab) * 30));

$lnpromediovariable = round($lnAcumuladoPromedioVariable + $lnAcumuladosNoPrest);

$f = new NumberFormatter("es", NumberFormatter::SPELLOUT);


?>



<!DOCTYPE html>
<html lang="en">



    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Charm&display=swap" rel="stylesheet">


        <link rel="stylesheet" href="bootstrap.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
                    body{
            font-family: 'Charm', cursive;
        }

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

        .footer {
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: right;
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
                    <br>
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
                    <div class="text-left">
                        <p>Identificado(a) con cedula de ciudadanìa <?php print $data[0]->nroidentificacion; ?> ha laborado
                            mediante contrato de trabajo por el termino que dure la obra o labor determinada en nuestra empresa usuaria: </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <br>
                    <h1 class="text-center"> <?php print $data[0]->empresa; ?>  </h1>
                    <br>
                </div>
            </div>

            <?php        //     echo $f->format($data[0]->salario); ?>  <?php // print number_format($data[0]->salario); ?>
            <div class="row ">
                <div class="col-sm">
                    <div class="text-just">
                        <p>Desempeñando la misiòn de <?php print $data[0]->cargo; ?> devengando un salario promedio mensual de  <?php  echo $f->format($lnPromedio); ?>  pesos mcte $<?php print number_format($lnPromedio); ?>

                        <?php if($lnPromedioNoprest > 50000){ ?>

                           mas auxilios no prestacionales para realizar su labor por un valor promedio de <?php print $f->format($lnPromedioNoprest) ?> pesos mcte $ <?php print number_format($lnPromedioNoprest); ?>

                        <?php } ?>



                           siendo la fecha de vinculacion del  <?php print $data[0]->dia_ingreso; ?> de  <?php print $data[0]->mes_ingreso; ?> del <?php print $data[0]->anualidad_ingreso; ?>  vigente a la fecha </p>
                    </div>

                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">

                    <div class="text-left">
                        <p> Se expide en Bucaramanga a los <?php print date('d'); ?> dias del mes <?php print strftime('%B'); ?> de <?php print date('Y'); ?>  </p>
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


                        <?php
                        /*
echo '<br>';
print 'lnAcumuladoPrest: '. $lnAcumuladoPrest;
echo '<br>';
print 'lnAcumuladosNoPrest: '. $lnAcumuladosNoPrest;
echo '<br>';
print 'lndias_lab: '. $lndias_lab;
echo '<br>';
print 'lnPromedioNoprest: '.$lnPromedioNoprest;
echo '<br>';
print 'lnPromedio: '.$lnPromedio;
echo '<br>';
print 'lnpromediovariable: '.$lnpromediovariable;
echo '<br>';
*/

                    ?>

            <div class="footer">
                <br>
                <p>___________________________________</p>
                <P>Calle 59 Nº 30-80 Bucaramanga: </P>
                <P>PBX 6573760 - Fax 6475770 </P>
                <P>Email: recepcion@genteutil.com</P>
                <br>
            </div>




            <div class="row btn-print">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.print();"> Imprimir
                    Documento </button>

            </div>

        </div>



    </body>


</html>
