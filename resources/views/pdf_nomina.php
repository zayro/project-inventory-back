<?php


// If you installed via composer, just use this code to require autoloader on the top of your projects.


ob_start();


require __DIR__ . '/../../vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
use Mpdf\Mpdf;

$pdo = new PDO('mysql:dbname=astgu;host=127.0.0.1', 'root', 'zayro8905');
 
$database = new Medoo([
	// Initialized and connected PDO object
	'pdo' => $pdo,
 
	// [optional] Medoo will have different handle method according to different database type
	'database_type' => 'mysql'
]);


$data = $database->query("SELECT vlpnomina.*, lpcuotasprestamos.detalle cuotaprestamo, lppagos.valor netoapagar, lppagos.idlpformaspago, lppagos.numerocheque, lppagos.numeropago, gbancos.nombre banco, vlpcontratos_empleados.nombrecompleto, 
vlpcontratos_empleados.nroidentificacion, vlpcontratos_empleados.salario, vlpcontratos_empleados.empresa, vlpcontratos_empleados.nombreeps, vlpcontratos_empleados.conceptocompensacionlab,
vlpcontratos_empleados.nombreafp, vlpcontratos_empleados.nombrearl, vlpcontratos_empleados.cargo, vlpcontratos_empleados.ciudad_laboral, vlpcontratos_empleados.salariointegral, lpformaspago.nombre formapago 
from vlpnomina left join lppagos on vlpnomina.idlpnominas = lppagos.idlpnominas and vlpnomina.idlpcontrato = lppagos.idlpcontrato
left join lpcuotasprestamos on vlpnomina.idlpcuotasprestamo = lpcuotasprestamos.idlpcuotasprestamo
left join lpformaspago on lppagos.idlpformaspago = lpformaspago.idlpformaspago 
left join gbancos on lpformaspago.idbanco = gbancos.idgbancos 
left join vlpcontratos_empleados on vlpnomina.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where vlpnomina.numeronomina = '$numeronomina' and vlpnomina.idlpcontrato = '$idlpcontrato'")->fetchAll(PDO::FETCH_OBJ);


?>



<!DOCTYPE html>
<html lang="en">



    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


        <link rel="stylesheet" href="bootstrap.min.css" >
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>

    <body>

   
    <?php  ob_start();      ?>


<div class="container">

<div >


        <table class="table table-bordered" autosize="2.4">

            <tr>
                <th colspan="2">GENTE UTIL S.A </th>
                <td colspan="4"><?php print $data[0]->periodoliquidacion; ?></td>
            </tr>

            <tr>
                <th colspan="2">Empleado en mision :</th>
                <td colspan="4"> <?php print $data[0]->empresa; ?> </td>
            </tr>

            <tr>
                <th>Nombre:</th>
                <td colspan="2"><?php print $data[0]->nombrecompleto; ?></td>
                <th>Identificacion:</th>
                <td colspan="2"> <?php print $data[0]->nroidentificacion; ?> </td>
            </tr>

            <tr>
                <th>Salario:</th>
                <td colspan="2"><?php print $data[0]->salario; ?></td>
                <th>Ciudad:</th>
                <td colspan="2"><?php print $data[0]->ciudad_laboral; ?></td>
            </tr>

            <tr>
                <th>Eps:</th>
                <td><?php print $data[0]->nombreeps; ?></td>
                <th>Afp:</th>
                <td><?php print $data[0]->nombreafp; ?></td>
                <th>Arl:</th>
                <td><?php print $data[0]->nombrearl; ?></td>

            </tr>

        </table>

  
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>H/D</th>
                        <th>Concepto</th>
                        <th>Devengados</th>
                        <th>Deducidos</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

            $devengado = 0;
            $deducido = 0;
            foreach ($data as $row){ ?>

                    <tr>
                        <td><?= $row->codigo;  ?></td>
                        <td><?= $row->numerohoras;  ?></td>
                        <td><?= $row->novedad;  ?></td>
                        <td><?php if($row->tipo == '1' || $row->tipo == '4') { print  $row->valor;  $devengado += $row->valor; } ?>
                        </td>
                        <td><?php if($row->tipo == '2' || $row->tipo == '3') { print  $row->valor; $deducido += $row->valor; } ?>
                        </td>
                    </tr>


                    <?php } ?>

                    <tr>
                        <td class="text-right" colspan="3"> Totales</td>
                        <td><?= $devengado; ?></td>
                        <td><?= $deducido; ?></td>
                    </tr>


                </tbody>
            </table>

            <table class="table table-borderless">
                <tr>
                    <th><?php print $data[0]->formapago; ?></th>
                    <th><?php if ( $data[0]->numerocheque > 0 ) { print $data[0]->nnumerocheque; } else { print  $data[0]->numeropago; } ?>
                    </th>
                    <td><?php print $data[0]->banco; ?></td>
                </tr>
                <tr>
                    <th>Nro Nomina: </th>
                    <th colspan="2"> <?php print $data[0]->numeronomina; ?> </th>
                </tr>
                <tr>
                    <th>Elaborado: </th>
                    <td colspan="2"> <?php print $data[0]->fecha; ?> Por:
                        <?php print $data[0]->nombreusuario .' '. $data[0]->apellidousuario ; ?> </td>
                </tr>
                <tr class="table-secondary">
                    <th> VALOR A PAGAR: </th>
                    <th colspan="2"> <?php print $data[0]->netoapagar; ?> </th>
                </tr>
                <tr>
                    <th> <?php print $data[0]->nombrecompleto; ?> </th>
                    <th colspan="2"> <?php print $data[0]->nroidentificacion ; ?> </th>
                </tr>
            </table>


        </div>

    </div>

    </body>


</html>
<?php 

$mpdf = new Mpdf();
$content = ob_get_clean();

$stylesheet = file_get_contents('bootstrap.css');
//$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($content, \Mpdf\HTMLParserMode::DEFAULT_MODE);
//$mpdf->WriteHTML($content);

$mpdf->Output();

//ob_end_clean();
//ob_end_flush();

?>