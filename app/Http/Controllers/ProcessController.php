<?php

namespace App\Http\Controllers;

use Validator;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Dotenv\Dotenv;
use PDO;

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
    public function ChangePassword(Request $request)
    {
        $this->validate($this->request, [
            'oldPass'     => 'required',
            'newPass'  => 'required',
            'user'  => 'required'
        ]);

        $oldPass = $request->input('oldPass');
        $newPass = $request->input('newPass');
        $user = $request->input('user');


        $result = $this->database->pdo->prepare("UPDATE vlpempleados set 
        passweb = '$newPass'
        WHERE
        passweb = '$oldPass' and nroidentificacion = '$user'  ");

        $result->execute();


        if ($result->rowCount() > 0) {
            return $this->handlers($result);
        } else {
            $msj['success'] = false;
            $msj['status'] = false;
            $msj['error'] = $this->database->error();
            $msj['sql'] = $this->database->log();
            return $msj;
        }
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
