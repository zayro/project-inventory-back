<?php

namespace App\Http\Controllers;

use Validator;
use Log;


use Illuminate\Http\Request;



use App\Http\Controllers\Controller;

use Dotenv\Dotenv;
use PDO;

/*
$dotenv = new Dotenv(__DIR__);
$dotenv->load();
*/


class ViewFormatController extends Controller
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

        $this->db = isset($params['db']) ? $params['db'] : null ;
        $this->table = isset($params['table']) ? $params['table'] : null ;
        $this->field = isset($params['field']) ? $params['field'] : null ;
        $this->condition = isset($params['condition']) ? $params['condition'] : null ;


        $this->connect($this->db);
    }

    public function pdfNomina(Request $request)
    {
        print($this->request);

        $numeronomina = $request->input('numeronomina');
        $idlpcontrato = $request->input('idlpcontrato');

        Log::info('This is some useful information.');

        Log::warning('Something could be going wrong.');
        
        Log::error('Something is really going wrong.');

        /*
        $this->validate($this->request, [
            'numeronomina'     => 'required',
            'idlpcontrato'  => 'required'
        ]);
        */

        return view('pdf_nomina', ['numeronomina' => $numeronomina, 'idlpcontrato' => $idlpcontrato]);
    }
   
    public function viewNomina(Request $request)
    {
        $numeronomina = $request->input('numeronomina');
        $idlpcontrato = $request->input('idlpcontrato');

        return view('view_nomina', ['numeronomina' => $numeronomina, 'idlpcontrato' => $idlpcontrato]);
    }
   

    public function viewLiquidacion(Request $request)
    {
        $nroliquidacion = $request->input('nroliquidacion');

        return view('view_liquidacion', ['nroliquidacion' => $nroliquidacion]);
    }
    
    public function viewCertificadoSalario(Request $request)
    {
        $idlpcontrato = $request->input('idlpcontrato');

        return view('view_certificado_salario', ['idlpcontrato' => $idlpcontrato]);
    }

    public function viewCertificadoTiempo(Request $request)
    {
        $idlpcontrato = $request->input('idlpcontrato');

        return view('view_certificado_tiempo', ['idlpcontrato' => $idlpcontrato]);
    }
    
    public function viewCertificadoDevengado(Request $request)
    {
        $idlpcontrato = $request->input('idlpcontrato');

        return view('view_certificado_devengado', ['idlpcontrato' => $idlpcontrato]);
    }
    
    public function viewEmail(Request $request)
    {
        $insert = $request->input('insert');
        $values = $request->input('values');
        $email = $request->input('email');
        $info = $request->input('info');

        //print_r($values);
        //print_r($email);


        if (count($values) == 1) {

            $save = [];
            $save['fechainicio'] = $values[0]['fechainicio'];
            $save['fechavencimiento'] = $values[0]['fechavencimiento'];
            $save['hospitalizacion'] = $values[0]['hospitalizacion'];
            $save['numerodias'] = $values[0]['numerodias'];
            $save['idlpempleado'] = $values[0]['idlpempleado'];
            $save['idlptipoausentismo'] = $values[0]['idlptipoausentismo'];
            $save['idlpdiagnosticos'] = $values[0]['idlpdiagnosticos'];
            $save['fecharegistro'] = $values[0]['fecharegistro'];
            $save['fechaaccidente'] = $values[0]['fechaaccidente'];
            
            


            $result = $this->database->insert($insert, $save);

            if ($this->database->error()[0] != 00000) {
                $msj['error'] = $this->database->error();
                $msj['sql'] = $this->database->log();
                return $msj;
             }else {
               return view(
                    'view_email',
                    [
                    'info' => $info, 'email' => $email['email'],
                    'nombrecompleto' => $email['nombrecompleto'],
                    'numerodias' => $values[0]['numerodias'],
                    'fechainicio' => $values[0]['fechainicio'],
                    'fechavencimiento' => $values[0]['fechavencimiento'],
                    'idlpempleado' => $values[0]['idlpempleado'],
                    'diagnostico' => $values[0]['diagnostico'],
                    'adjunto' => $values[0]['adjunto']
                    ]
                );
             }

        } else {
            $result = $this->database->insert($insert, $create);
            if ($this->database->error()[0] != 00000) {
                $msj['error'] = $this->database->error();
                $msj['sql'] = $this->database->log();
                return $msj;
            } else {
                 return view(
                'view_email',
                [
                'info' => $info, 'email' => $email['email'],
                'nombrecompleto' => $email['nombrecompleto'],
                'numerodias' => $values[0]['numerodias'],
                'fechainicio' => $values[0]['fechainicio'],
                'fechavencimiento' => $values[0]['fechavencimiento'],
                'idlpempleado' => $values[0]['idlpempleado'],
                'diagnostico' => $values[0]['diagnostico'],
                'adjunto' => $values[0]['adjunto']
                ]
            );
            }
        }

        
        /*         if ($values[0]['tipoentidad'] == '0') {
                    $tipoentidad = 'accidente laboral';
                } elseif ($values[0]['tipoentidad'] == '1') {
                    $tipoentidad = 'enfermedad';
                } else {
                    $tipoentidad = 'embarazo';
                } */

          

    }

    public function viewFolder(Request $request)
    {
        $ruta = $request->input('ruta');

        $registros = array();
        $nombre = array();

        // comprobamos si lo que nos pasan es un directorio

        if (is_dir($ruta)) {
            // Abrimos el directorio y comprobamos que

            if ($aux = opendir($ruta)) {
                while (false !== ($archivo = readdir($aux))) {
                    // Si quisieramos mostrar todo el contenido del directorio pondríamos lo siguiente:
                    // echo '<br />' . $file . '<br />';
                    // Pero como lo que queremos es mostrar todos los archivos excepto "." y ".."

                    if ('.' != $archivo && '..' != $archivo && '.htaccess' != $archivo) {
                        $ruta_completa = $ruta.'/'.$archivo;

                        // Comprobamos si la ruta más file es un directorio (es decir, que file es
                        // un directorio), y si lo es, decimos que es un directorio y volvemos a
                        // llamar a la función de manera recursiva.

                        if (is_dir($ruta_completa)) {
                            //echo "<br /><strong>Directorio:</strong> " . $ruta_completa;
                            //leer_archivos_y_directorios($ruta_completa . "/");
                        } else {
                            //  echo '<br />' . $archivo . '<br />';
                            $nombre['nombre'] = utf8_encode($archivo);
                            $nombre['ruta'] = utf8_encode($ruta);
                            array_push($registros, $nombre);

                            $datos['archivos'] = $registros;
                        }
                    }
                }

                closedir($aux);

                // Tiene que ser ruta y no ruta_completa por la recursividad
            # echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
            }
        } else {
            $datos['path'] = $ruta;
            $datos['error'] = 'No es ruta valida';

        }

        return $datos;
    }


    public function DowloadFile(Request $request)
    {
        $ruta = $request->input('ruta');
   
        //print $ruta;
        return response()->download($ruta);
    }
}
