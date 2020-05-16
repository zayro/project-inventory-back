<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * CLASE DE CARGAR DE ARCHIVOS.
 *
 * En esta parte nos encargamos de crear un manejador de carpetas elimnar, mover, crear
 *
 * @author MARLON ZAYRO ARIAS VARGAS
 *
 * @version 1.0
 */
class file extends Controller
{
    /**
     * @param type $ruta
     *
     * @throws Exception
     */
    public function crear_carpeta(Request $request)
    {
        if (!mkdir($request->input('path'), 0777, true)) {
            throw new Exception('ocurrio un error al crear la carpeta');
        }
    }

    /**
     * @param type $ruta
     * @param type $destino
     *
     * @throws Exception
     */
    public function mover_archivos(Request $request)
    {
        if (!rename($request->input('origin'), $request->input('destination'))) {
            throw new Exception('ocurrio un error al redireccionar archivo');
        }
    }

    /**
     * @param type $ruta_antigua
     * @param type $ruta_nueva
     *
     * @throws Exception
     */
    public function renombrar_carpeta($ruta_antigua, $ruta_nueva)
    {
        if (!rename($ruta_antigua, $ruta_nueva)) {
            throw new Exception('ocurrio un error al redireccionar archivo');
        }
    }

    /**
     * @param type $archivo
     *
     * @return bool
     */
    public function eliminar_archivo($archivo)
    {
        if (!unlink($archivo)) {
            return "ocurrio un problema $archivo";
        } else {
            return true;
        }
    }

    /**
     * @param type $ruta
     */
    public function eliminar_carpeta(Request $request)
    {
        if (is_dir($request->input('path'))) {
            rmdir($request->input('path'));
        } else {
            echo 'no existe la ruta: '.$request->input('path');
        }
    }

    /**
     * @param type $carpeta
     */
    public function eliminar_contenido_carpeta($carpeta)
    {
        foreach (glob($carpeta.'/*') as $archivos_carpeta) {
            //archivos a eliminar
            //echo $archivos_carpeta;

            if (is_dir($archivos_carpeta)) {
                eliminar_contenido_carpeta($archivos_carpeta);
            } else {
                unlink($archivos_carpeta);
            }
        }

        rmdir($carpeta);
    }

    /**
     * @param type $ruta
     *
     * @return array
     */
    public function ver_carpeta($ruta)
    {
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
//   echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
            }
        } else {
            echo $ruta;
            echo '<br />No es ruta valida';
        }

        return $datos;
    }

    public function dirToArray($dir) {

        $result = array();
     
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value)
        {
           if (!in_array($value,array(".","..")))
           {
              if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
              {
                 $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
              }
              else
              {
                 $result[] = $value;
              }
           }
        }
       
        return $result;
     }
     
     public function scanDirectories($rootDir, $allData=array()) {
         // set filenames invisible if you want
         $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd");
         // run through content of root directory
         $dirContent = scandir($rootDir);
         foreach($dirContent as $key => $content) {
             // filter all files not accessible
             $path = $rootDir.'/'.$content;
             if(!in_array($content, $invisibleFileNames)) {
                 // if content is file & readable, add to array
                 if(is_file($path) && is_readable($path)) {
                     // save file name with path
                     $allData[] = $path;
                 // if content is a directory and readable, add path and name
                 }elseif(is_dir($path) && is_readable($path)) {
                     // recursive callback to open new directory
                     $allData = scanDirectories($path, $allData);
                 }
             }
         }
         return $allData;
     }
}
