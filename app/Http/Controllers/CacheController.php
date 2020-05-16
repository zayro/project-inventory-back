<?php

namespace App\Http\Controllers;

use Validator;
use Log;
use PDO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Dotenv\Dotenv;


use App\Http\Controllers\Controller;

/*
$dotenv = new Dotenv(__DIR__);
$dotenv->load();
*/


class CacheController extends Controller
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


    public function index()
    {
        if (Cache::has('key')) {
            //
            $value = Cache::get('key');
        } else {
            Cache::add('key', 'value', 200);
        }
        

        return $value;
    }

    public function get_and_delete()
    {
        $articles = Cache::pull('key');
    }

    

    public function remove()
    {
        Cache::forget('key');
    }

    public function update()
    {
        Cache::put('key', $values, 10);
    }


    public function clean()
    {
        Cache::flush();
    }

    public function diagnosticoQuery()
    {
        $from  = 'lpdiagnosticos';
        $fields = '*';
        $where = [];
        $result = $this->database->select($from, $fields);


        if (count($result) > 0) {
            return response()->json([
                'status' => true,
                'result' => $result,
                'message' => "Auth Success",
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'result' => $result,
                'message' => "Auth Denid"
            ], 401);
        }
    }


    public function diagnostico()
    {
    
        if (Cache::has('lpdiagnosticos')) {
            $response = Cache::get('lpdiagnosticos');
               
            return response()->json($response, 202);
        } else {
            $from  = 'lpdiagnosticos';
            $fields = '*';
            $where = [];
            $result = $this->database->select($from, $fields);
        
        
            if (count($result) > 0) {
                $response = [
                        'status' => true,
                        'result' => $result,
                        'message' => "Auth Success",
                    ];

                Cache::add('lpdiagnosticos', $response, 200);
                return response()->json($response, 200);
            } else {
                return response()->json([
                        'status' => false,
                        'result' => $result,
                        'message' => "Auth Denid"
                    ], 401);
            }
        }
    }
}
