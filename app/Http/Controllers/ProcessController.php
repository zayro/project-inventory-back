<?php

namespace App\Http\Controllers;

use Validator;
use Log;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Dotenv\Dotenv;

use PDO;
use PDOException;
use Throwable;

class ProcessController extends Controller
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
    public function invoice(Request $request)
    {

        $this->connect('inventario');


        $maestro_movimiento = $request->input('maestro_movimiento');
        $detalle_movimiento = $request->input('detalle_movimiento');
        

        #print count($detalle_movimiento);

        #print_r($detalle_movimiento);

        $descripcion = $maestro_movimiento['descripcion'];
        $descuento = $maestro_movimiento['descuento'];
        $impuesto = $maestro_movimiento['impuesto'];
        $total = $maestro_movimiento['total'];
        $id_tipo_comprobante = $maestro_movimiento['id_tipo_comprobante'];
        $id_tipo_pago = $maestro_movimiento['id_tipo_pago'];
        $identificacion_tercero = $maestro_movimiento['identificacion_tercero'];
        $identificacion_usuario = $maestro_movimiento['identificacion_usuario'];

        $this->database->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->database->pdo->beginTransaction();

        $sql_maestro = "INSERT INTO maestro_movimiento (id, descripcion, descuento, impuesto, total, id_tipo_comprobante, id_tipo_pago, identificacion_tercero, identificacion_usuario) SELECT  MAX(id)+1, '$descripcion', '$descuento', '$impuesto', '$total', '$id_tipo_comprobante', '$id_tipo_pago', '$identificacion_tercero', '$identificacion_usuario' FROM maestro_movimiento ";


        $maestro = $this->database->query($sql_maestro);     

        if(!$maestro){
            $msj['success'] = false;
            $msj['status'] = false;            
            #$msj['Exception'] = $maestro->errorInfo();
            $msj['msj'] = 'error maestro';          
            $msj['error'] = $this->database->error();
            $msj['sql'] = $this->database->log();
            $this->database->pdo->rollBack();
            return $msj;
        }       

        #Log::info($sql_maestro);

        
        foreach ($detalle_movimiento as $row) {

            #print_r($row);
            $id_producto = $row['id'];
            $cantidad = $row['cantidad'];
            $precio = $row['precio_venta'];

            $sql_detalle = "INSERT INTO detalle_movimiento (id, id_producto, cantidad, precio, id_maestro_movimiento) SELECT (SELECT MAX(id)+1 from detalle_movimiento), '$id_producto', '$cantidad', '$precio',  MAX(id) FROM  maestro_movimiento";

            //$detalle = $this->database->pdo->prepare($sql_detalle)->execute();
            $detalle = $this->database->query($sql_detalle);
            if(!$detalle){
                $msj['success'] = false;
                $msj['status'] = false;            
                #$msj['Exception'] = $detalle->errorInfo();        
                $msj['msj'] = 'error detalle';
                $msj['error'] = $this->database->error();
                $msj['sql'] = $this->database->log();
                $this->database->pdo->rollBack();
                return $msj;
            }       

        }

    
            $this->database->pdo->commit();
            $msj['success'] = true;
            $msj['status'] = true;
            $msj['sql'] = $this->database->log();            
            $msj['message'] = 'Proceso Enviado';
            return $msj;


    
        
        
    }
    

    /**
     * MANEJADOR.
     *
     * Almacena los registros en la base de datos
     * devuelve json los datos procesados
     *
     * @param array $data se reciben los datos a eliminar en bosque
     */
    public function handlers($result)
    {
        if ($this->database->error()[0] != 00000) {
            $msj['success'] = false;
            $msj['status'] = false;
            $msj['error'] = $this->database->error();
            $msj['sql'] = $this->database->log();
        } else {
            $msj['success'] = true;
            $msj['status'] = true;
            //$msj['sql'] = $this->database->log();
            $msj['count'] = method_exists($result, 'rowCount') ? $result->rowCount() : count($result);
            $msj['message'] = 'Proceso Enviado';
            $msj['data'] = $result;
        }

        return $msj;
    }
}
