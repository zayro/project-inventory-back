<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require __DIR__ . '/../../vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
use Mpdf\Mpdf;

$pdo = new PDO('mysql:dbname=astgu;host=127.0.0.1', 'marlon3013199303', 'zayro3013199303');
 
$database = new Medoo([
	// Initialized and connected PDO object
	'pdo' => $pdo,
 
	// [optional] Medoo will have different handle method according to different database type
	'database_type' => 'mysql'
]);


//ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php


$data = $database->query("SELECT vlpnomina.*, lpcuotasprestamos.detalle cuotaprestamo, lppagos.valor netoapagar, lppagos.idlpformaspago, lppagos.numerocheque, lppagos.numeropago, gbancos.nombre banco, vlpcontratos_empleados.nombrecompleto, 
vlpcontratos_empleados.nroidentificacion, vlpcontratos_empleados.salario, vlpcontratos_empleados.empresa, vlpcontratos_empleados.nombreeps, vlpcontratos_empleados.conceptocompensacionlab,
vlpcontratos_empleados.nombreafp, vlpcontratos_empleados.nombrearl, vlpcontratos_empleados.cargo, vlpcontratos_empleados.ciudad_laboral, vlpcontratos_empleados.salariointegral, lpformaspago.nombre formapago 
from vlpnomina left join lppagos on vlpnomina.idlpnominas = lppagos.idlpnominas and vlpnomina.idlpcontrato = lppagos.idlpcontrato
left join lpcuotasprestamos on vlpnomina.idlpcuotasprestamo = lpcuotasprestamos.idlpcuotasprestamo
left join lpformaspago on lppagos.idlpformaspago = lpformaspago.idlpformaspago 
left join gbancos on lpformaspago.idbanco = gbancos.idgbancos 
left join vlpcontratos_empleados on vlpnomina.idlpcontrato = vlpcontratos_empleados.idlpcontrato
where vlpnomina.numeronomina = '00006664-201212' and vlpnomina.idlpcontrato = '22833'")->fetchAll(PDO::FETCH_OBJ);



?>

<div class="container-fluid">





<table class="table">

    <tr>
        <td>GENTE UTIL S.A</td>
        <td >EMPLEADO MISION EN:</td>
        <td colspan="4"></td>
    </tr>

    <tr>
        <td colspan="3">Empleado en mision :</td>
        <td colspan="3">   </td>
    </tr>

    <tr>
        <td>Nombre:</td>       <td colspan="2"></td>
        <td>Identificacion:</td>       <td colspan="2"></td>
    </tr>

    <tr>
    <td>Salario:</td>       <td colspan="2"></td>
    <td>Ciudad:</td>       <td colspan="2"></td>        
    </tr>

    <tr>
    <td>Eps:</td>       <td></td>
    <td>Afp:</td>       <td></td>    
    <td>Arl:</td>       <td></td>
            
    </tr>

</table>


<table class="table table-bordered">
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

<?php foreach ($data as $row){ ?>

    <tr>
        <td><?= $row->codigo;  ?></td>
        <td><?= $row->novedad;  ?></td>
        <td><?= $row->novedad;  ?></td>
        <td><?= $row->novedad;  ?></td>
        <td><?= $row->novedad;  ?></td>
    </tr>
    

<?php } ?>

<tr>
    <td class="text-right" colspan="3"> Totales</td>
    <td>$</td>
    <td>$</td>
</tr>


</tbody>
</table>


</div>




</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<?php 

/*

$content = ob_get_clean();



$mpdf = new Mpdf();

//$html = file_get_contents($content);

//$html = utf8_encode($html);

$mpdf->WriteHTML($content);

$mpdf->Output('nomina.pdf', \Mpdf\Output\Destination::INLINE);

ob_end_clean(); 
*/

?>
</html>