<?php

namespace App\Http\Controllers\query;

use Validator;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class ViewController extends Controller
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
   

    public function view_privileges ()
    {

        $email = $request->input('email');

        $sql = "SELECT menu, link FROM view_privileges where email = '$email'";

        $result =  $this->database->query("$sql")->fetchAll();
        return $this->handlers($result);
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
            $msj['error'] = $this->database->error();
            $msj['sql'] = $this->database->log();
        } else {
            $msj['success'] = true;
            //$msj['sql'] = $this->database->log();
            $msj['count'] = method_exists($result, 'rowCount') ? $result->rowCount() : count($result);
            $msj['message'] = 'Proceso Enviado';
            $msj['data'] = $result;
        }

        return $msj;
    }
}
