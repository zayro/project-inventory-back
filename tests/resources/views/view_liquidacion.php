<?php

// If you installed via composer, just use this code to require autoloader on the top of your projects.
//ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;
use Mpdf\Mpdf;
use Dotenv\Dotenv;

//$dotenv->load();

$pdo = new PDO('mysql:dbname='.getenv('DB_DATABASE').';host='.getenv('DB_HOST').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

$database = new Medoo([
	// Initialized and connected PDO object
	'pdo' => $pdo,

	// [optional] Medoo will have different handle method according to different database type
	'database_type' => 'mysql'
]);


$data = $database->query("SELECT
vlpliquidaciones.*,
lppagos.valor as netoapagar,
lppagos.numerocheque,
lppagos.numeropago,
gbancos.nombre banco,
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.nombreeps,
vlpcontratos_empleados.nombreafp,
vlpcontratos_empleados.nombrearl,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.ciudad_laboral,
lpformaspago.nombre formapago
from
vlpliquidaciones
left join lppagos on
vlpliquidaciones.idlpliquidaciones = lppagos.idlpliquidaciones
left join lpformaspago on
lppagos.idlpformaspago = lpformaspago.idlpformaspago
left join gbancos on
lpformaspago.idbanco = gbancos.idgbancos
left join vlpcontratos_empleados on
lppagos.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where
vlpliquidaciones.cesantiasconsignadas = '0'
and
vlpliquidaciones.numeroliquidacion = '$nroliquidacion'")->fetchAll(PDO::FETCH_OBJ);


$prestaciones = $database->query("SELECT
vlpliquidaciones.*,
lppagos.valor as netoapagar,
lppagos.numerocheque,
lppagos.numeropago,
gbancos.nombre banco,
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.nombreeps,
vlpcontratos_empleados.nombreafp,
vlpcontratos_empleados.nombrearl,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.ciudad_laboral,
lpformaspago.nombre formapago
from
vlpliquidaciones
left join lppagos on
vlpliquidaciones.idlpliquidaciones = lppagos.idlpliquidaciones
left join lpformaspago on
lppagos.idlpformaspago = lpformaspago.idlpformaspago
left join gbancos on
lpformaspago.idbanco = gbancos.idgbancos
left join vlpcontratos_empleados on
lppagos.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where
vlpliquidaciones.cesantiasconsignadas = '0'
and
tipo = '4'
and
vlpliquidaciones.numeroliquidacion = '$nroliquidacion'")->fetchAll(PDO::FETCH_OBJ);

$devengados = $database->query("SELECT
vlpliquidaciones.*,
lppagos.valor as netoapagar,
lppagos.numerocheque,
lppagos.numeropago,
gbancos.nombre banco,
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.nombreeps,
vlpcontratos_empleados.nombreafp,
vlpcontratos_empleados.nombrearl,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.ciudad_laboral,
lpformaspago.nombre formapago
from
vlpliquidaciones
left join lppagos on
vlpliquidaciones.idlpliquidaciones = lppagos.idlpliquidaciones
left join lpformaspago on
lppagos.idlpformaspago = lpformaspago.idlpformaspago
left join gbancos on
lpformaspago.idbanco = gbancos.idgbancos
left join vlpcontratos_empleados on
lppagos.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where
vlpliquidaciones.cesantiasconsignadas = '0'
and
tipo = '1'
and
vlpliquidaciones.numeroliquidacion = '$nroliquidacion'")->fetchAll(PDO::FETCH_OBJ);

$deducidos = $database->query("SELECT
vlpliquidaciones.*,
lppagos.valor as netoapagar,
lppagos.numerocheque,
lppagos.numeropago,
gbancos.nombre banco,
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.nombreeps,
vlpcontratos_empleados.nombreafp,
vlpcontratos_empleados.nombrearl,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.ciudad_laboral,
lpformaspago.nombre formapago
from
vlpliquidaciones
left join lppagos on
vlpliquidaciones.idlpliquidaciones = lppagos.idlpliquidaciones
left join lpformaspago on
lppagos.idlpformaspago = lpformaspago.idlpformaspago
left join gbancos on
lpformaspago.idbanco = gbancos.idgbancos
left join vlpcontratos_empleados on
lppagos.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where
vlpliquidaciones.cesantiasconsignadas = '0'
and
tipo in (2, 3)
and
vlpliquidaciones.numeroliquidacion = '$nroliquidacion'")->fetchAll(PDO::FETCH_OBJ);

$cesantias = $database->query("SELECT
vlpliquidaciones.*,
lppagos.valor as netoapagar,
lppagos.numerocheque,
lppagos.numeropago,
gbancos.nombre banco,
vlpcontratos_empleados.nombrecompleto,
vlpcontratos_empleados.nroidentificacion,
vlpcontratos_empleados.salario,
vlpcontratos_empleados.empresa,
vlpcontratos_empleados.nombreeps,
vlpcontratos_empleados.nombreafp,
vlpcontratos_empleados.nombrearl,
vlpcontratos_empleados.cargo,
vlpcontratos_empleados.ciudad_laboral,
lpformaspago.nombre formapago
from
vlpliquidaciones
left join lppagos on
vlpliquidaciones.idlpliquidaciones = lppagos.idlpliquidaciones
left join lpformaspago on
lppagos.idlpformaspago = lpformaspago.idlpformaspago
left join gbancos on
lpformaspago.idbanco = gbancos.idgbancos
left join vlpcontratos_empleados on
lppagos.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where
vlpliquidaciones.cesantiasconsignadas = '1'
and
vlpliquidaciones.numeroliquidacion = '$nroliquidacion'")->fetchAll(PDO::FETCH_OBJ);

if(count($cesantias) <= 0){

    //print "no cuenta con cesantias registradas en el sistemas";
    
    //exit();
} else {
    $fecha_cesantia = date("Y", strtotime($cesantias[0]->fecharetiro));
}


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
                    <div class="text-center">
                        <img src="./assets/images/logo_gu.png" width="245" height="102" alt="...">
                    </div>

                </div>
                <div class="col-sm">
                    <p class="text-sm-left">GENTE UTIL S.A</p>
                    <p class="text-sm-left">NIT 804.004.319-9 - BUCARAMANGA</p>
                    <p class="text-sm-left">LIQUIDACION DE PRESTACIONES SOCIALES</p>
                    <p class="text-sm-left">POR RETIRO DEFINITIVO DE LA EMPRESA</p>
                    <p class="text-sm-left">POR TERMINACION DE LA OBRA TERMINADA</p>


                </div>
            </div>


            <div class="row">


                <table class="table table-bordered" autosize="2.4">

                    <tr>
                        <th colspan="2">Liquidacion</th>
                        <td colspan="4"><?php print $data[0]->numeroliquidacion; ?></td>
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
                        <th>Cargo:</th>
                        <td colspan="2"><?php print $data[0]->cargo; ?></td>
                        <th>Ciudad:</th>
                        <td colspan="2"><?php print $data[0]->ciudad_laboral; ?></td>
                    </tr>


                </table>





            </div>

            <div class="row">
                <div class="col-sm">
                    <table class="table table-sm">
                        <caption></caption>
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" colspan="2">Periodo de Liquidacion</th>

                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>FECHA INGRESO</th>
                                <td> <?php print $data[0]->fechaingreso;  ?></td>
                            </tr>
                            <tr>
                                <th>FECHA RETIRO </th>
                                <td> <?php print $data[0]->fecharetiro;  ?> </td>
                            </tr>
                            <tr>
                                <th>TIEMPO LABORADO </th>
                                <td> <?php print $data[0]->diaslaborados;  ?> </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="col-sm">
                    <table class="table table-sm">
                        <caption></caption>
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" colspan="2">Bases de Liquidacion</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Indice Base de liquidacion</th>
                                <td> <?php print number_format($data[0]->ibl);  ?></td>
                            </tr>
                            <tr>
                                <th>Indice Base de liquidacion para vacaciones</th>
                                <td> <?php print number_format($data[0]->iblvacaciones);  ?> </td>
                            </tr>



                        </tbody>

                        <tfoot>
                            <tr>
                                <th><?php print 'Numero Cuenta '. $data[0]->formapago  .' '. $data[0]->banco ; ?></th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>


            <div class="row">
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" colspan="5">Prestaciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <th>codigo</th>
                            <th>Concepto</th>
                            <th>Dias</th>
                            <th>Devengados</th>
                            <th>Deducidos</th>
                        </tr>

                        <?php

                            $devengado = 0;
                            $deducido = 0;
                            foreach ($prestaciones as $row){

                            ?>

                        <tr >

                            <td><?= $row->codigo;  ?></td>
                            <td><?= $row->novedad;  ?></td>
                            <td><?php if ($row->numerodias > 0) {  print $row->numerodias ; } else { print  $row->numerohoras ; }  ?>
                            </td>
                            <td><?php if($row->tipo == '1' || $row->tipo == '4') { print  number_format($row->valor);  $devengado += $row->valor; } ?>
                            </td>
                            <td><?php if($row->tipo == '2' || $row->tipo == '3') { print  number_format($row->valor); $deducido += $row->valor; } ?>
                            </td>
                        </tr>


                        <?php } ?>


                        <tr class="table-primary">
                            <th scope="col" colspan="3"></th>
                            <th scope="col" colspan="1"><?= number_format($devengado); ?></th>
                            <th scope="col" colspan="1"><?= number_format($deducido); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php   if (count($devengados) > 0) {    ?>

            <div class="row">
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" colspan="5">Devengados </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <th>codigo</th>
                            <th>Concepto</th>
                            <th>Dias</th>
                            <th>Devengados</th>
                            <th>Deducidos</th>
                        </tr>

                        <?php

                            $devengado = 0;
                $deducido = 0;
                foreach ($devengados as $row) {
                    ?>

                        <tr >

                            <td><?= $row->codigo; ?></td>
                            <td><?= $row->novedad; ?></td>
                            <td><?php if ($row->numerodias > 0) {
                        print $row->numerodias ;
                    } else {
                        print  $row->numerohoras ;
                    } ?>
                            </td>
                            <td><?php if ($row->tipo == '1' || $row->tipo == '4') {
                        print  number_format($row->valor);
                        $devengado += $row->valor;
                    } ?>
                            </td>
                            <td><?php if ($row->tipo == '2' || $row->tipo == '3') {
                        print  number_format($row->valor);
                        $deducido += $row->valor;
                    } ?>
                            </td>
                        </tr>


                        <?php } ?>


                        <tr class="table-primary">
                            <th scope="col" colspan="3"></th>
                            <th scope="col" colspan="1"><?= number_format($devengado); ?></th>
                            <th scope="col" colspan="1"><?= number_format($deducido); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php
            }

            ?>


            <div class="row">
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" colspan="5">Deducidos</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <th>codigo</th>
                            <th>Concepto</th>
                            <th>Dias</th>
                            <th>Devengados</th>
                            <th>Deducidos</th>
                        </tr>

                        <?php

                            $devengado = 0;
                            $deducido = 0;
                            foreach ($deducidos as $row){

                            ?>

                        <tr >

                            <td><?= $row->codigo;  ?></td>
                            <td><?= $row->novedad;  ?></td>
                            <td><?php if ($row->numerodias > 0) {  print $row->numerodias ; } else { print  $row->numerohoras ; }  ?>
                            </td>
                            <td><?php if($row->tipo == '1' || $row->tipo == '4') { print  number_format($row->valor);  $devengado += $row->valor; } ?>
                            </td>
                            <td><?php if($row->tipo == '2' || $row->tipo == '3') { print  number_format($row->valor); $deducido += $row->valor; } ?>
                            </td>
                        </tr>


                        <?php } ?>


                        <tr class="table-primary">
                            <th scope="col" colspan="3"></th>
                            <th scope="col" colspan="1"><?= number_format($devengado); ?></th>
                            <th scope="col" colspan="1"><?= number_format($deducido); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="text-center">

                    <h3>OBSERVACIONES</h3>

                    <?php    if(count($cesantias) > 0){  ?>


                    <table class="table">
                        <tr>
                            <th>PAGO DE CESANTIAS A DICIEMBRE / <?php print $fecha_cesantia - 1; ?>  </th>
                            <td> <?php print number_format($cesantias[0]->valor); ?> </td>
                        </tr>
                        <tr>
                            <th>Recibí de Gente Util la cantidad de</th>
                            <td> <?php $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                            echo $f->format($data[0]->netoapagar);  ?> pesos mcte  $ <?php  print number_format($data[0]->netoapagar); ?> </td>

                        </tr>

                    <?php  } ?>                        



                        <tr>
                            <td colspan="2">
                                <p class="text-justify">Valor de mis prestaciones sociales conforme a la liquidaciòn
                                    anterior.
                                    Dejo constancia de que GENTE UTIL S.A, queda a Paz y Salvo conmigo por todo concepto
                                    de
                                    Prestaciones Sociales que ordena la Ley y que todos los sueldos me fueron pagados en los
                                    periodos  acostumbrados. </p>
                            </td>
                        </tr>
                        <tr>

                            <th>
                                <p class="text-left"> Numero de documento de pago: </p>
                            </th>
                            <th> <?php if ($data[0]->numerocheque > 0) { print $data[0]->numerocheque; } else{ print $data[0]->numeropago;  }   ?>
                            </th>
                        </tr>

                        <tr>
                            <th>
                                <p class="text-left"> Banco: </p>
                            </th>
                            <th> <?php print $data[0]->banco;  ?> </th>


                        </tr>

                        <tr>
                            <th>
                                <p class="text-left"> Elaborado por: </p>
                            </th>
                            <th> <?php print $data[0]->nombreusuario.' '.$data[0]->apellidousuario;  ?> </th>
                        </tr>

                        <tr>
                            <th>
                                <p class="text-left"> Fecha de elaboracion: </p>
                            </th>
                            <th> <?php print $data[0]->fecha;  ?> </th>
                        </tr>

                    </table>
                </div>

            </div>

            <div class="row btn-print">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.print();"> Imprimir
                    Documento </button>

            </div>

        </div>

    </body>


</html>
