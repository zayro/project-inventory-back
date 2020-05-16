<?php

namespace App\Http\Controllers;

use Validator;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


use tibonilab\Pdf\PdfFacade as PDF;
use Mpdf\Mpdf;

use App\Http\Controllers\Controller;

use Dotenv\Dotenv;
use PDO;

/*
$dotenv = new Dotenv(__DIR__);
$dotenv->load();
*/


class QueryController extends Controller
{
    private $db;
    private $table;
    private $field;
    private $condition;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
     
        list($found, $routeInfo, $params) = $request->route() ?: [false, [], []];

        $this->db = isset($params['db']) ? $params['db'] :  getenv('DB_DATABASE') ;

        $this->connect($this->db);
    }
   
    /**
     *
     */
    public function BuscarEmpleados(Request $request, $nroidentificacion)
    {

        //$nroidentificacion = $request->input('nroidentificacion');

        $result = $this->database->query("SELECT *
        from vlpnomina left join vlpcontratos_empleados
        on vlpnomina.idlpcontrato = vlpcontratos_empleados.idlpcontrato
        WHERE
        vlpcontratos_empleados.nroidentificacion = '$nroidentificacion' and vlpnomina.anulado = 0 group by vlpnomina.numeronomina, vlpnomina.idlpcontrato;")->fetchAll(PDO::FETCH_ASSOC);

        return $this->handlers($result);
    }
    

    public function InformacionNomina(Request $request, $numeronomina, $idlpcontrato)
    {
        $result = $this->database->query("SELECT vlpnomina.*, lpcuotasprestamos.detalle cuotaprestamo, lppagos.valor netoapagar, lppagos.idlpformaspago, lppagos.numerocheque, lppagos.numeropago, gbancos.nombre banco, vlpcontratos_empleados.nombrecompleto, 
        vlpcontratos_empleados.nroidentificacion, vlpcontratos_empleados.salario, vlpcontratos_empleados.empresa, vlpcontratos_empleados.nombreeps, vlpcontratos_empleados.conceptocompensacionlab,
        vlpcontratos_empleados.nombreafp, vlpcontratos_empleados.nombrearl, vlpcontratos_empleados.cargo, vlpcontratos_empleados.ciudad_laboral, vlpcontratos_empleados.salariointegral, lpformaspago.nombre formapago 
        from vlpnomina left join lppagos on vlpnomina.idlpnominas = lppagos.idlpnominas and vlpnomina.idlpcontrato = lppagos.idlpcontrato
        left join lpcuotasprestamos on vlpnomina.idlpcuotasprestamo = lpcuotasprestamos.idlpcuotasprestamo
        left join lpformaspago on lppagos.idlpformaspago = lpformaspago.idlpformaspago 
        left join gbancos on lpformaspago.idbanco = gbancos.idgbancos 
        left join vlpcontratos_empleados on vlpnomina.idlpcontrato = vlpcontratos_empleados.idlpcontrato  
        where vlpnomina.numeronomina = '$numeronomina' and vlpnomina.idlpcontrato = '$idlpcontrato'")->fetchAll();

        return $this->handlers($result);
    }


    public function BuscarLiquidaciones(Request $request, $nroidentificacion)
    {
        $result = $this->database->query("SELECT
            vlpliquidaciones.numeroliquidacion,
            vlpcontratos_empleados.empresa
        from
            vlpliquidaciones
        left join vlpcontratos_empleados on
            vlpliquidaciones.idlpcontrato = vlpcontratos_empleados.idlpcontrato
        where
            vlpcontratos_empleados.nroidentificacion = '$nroidentificacion'
            AND vlpliquidaciones.anulado = 0 
        group by
            vlpliquidaciones.numeroliquidacion,
            vlpliquidaciones.idlpcontrato;
        ")->fetchAll();

        return $this->handlers($result);
    }


    public function InformacionLiquidaciones(Request $request, $nroliquidacion)
    {
        $result = $this->database->query("SELECT
            vlpliquidaciones.*,
            lppagos.valor netoapagar,
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
            vlpliquidaciones.numeroliquidacion = '$nroliquidacion';
        ")->fetchAll();

        return $this->handlers($result);
    }

    public function BuscarCertificaciones(Request $request, $nroidentificacion)
    {
        $sql = "SELECT vlpcontratos_empleados.nombrecompleto, vlpcontratos_empleados.nroidentificacion, vlpcontratos_empleados.tipodocumento, vlpcontratos_empleados.idlpcontrato, vlpcontratos_empleados.empresa, 
	vlpcontratos_empleados.cargo, vlpcontratos_empleados.fechaingreso fechaingreso, 
	vlpcontratos_empleados.fecharetiro, vlpcontratos_empleados.salario,
	vlpcontratos_empleados.salario promedio, vlpcontratos_empleados.salario noprestacional,
	vlpcontratos_empleados.numerohoras, vlpcontratos_empleados.numerohoras diaslaborados, 
	vlpcontratos_empleados.salario valor_variable, vlpcontratos_empleados.salario prestacional, 
	vlpcontratos_empleados.idlpestadoscontratos, vlpcontratos_empleados.idempresas idempresas 
	from vlpcontratos_empleados where  vlpcontratos_empleados.nroidentificacion = '$nroidentificacion' 
    and vlpcontratos_empleados.idlpestadoscontratos in (2,3,4,6)";

        $result = $this->database->query($sql)->fetchAll();


        return $this->handlers($result);
    }
}
