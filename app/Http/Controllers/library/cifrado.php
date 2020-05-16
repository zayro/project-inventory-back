<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class cifrado
{
    public function __construct()
    {
    }

    public static function hashSha1(string $sContrasenia): string
    {
        return sha1($sContrasenia);
    }

    public static function generateSalt()
    {
        $iSaltLength = 10;
        $sCharsetSalt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789][{};:?.>,<!@#$%^&*()-_=+|';
        $sRandString = '';

        for ($i = 0; $i < $iSaltLength; ++$i) {
            $sRandString .= $sCharsetSalt[mt_rand(0, strlen($sCharsetSalt) - 1)];
        }

        return $sRandString;
    }

    public static function generatePassword(): string
    {
        $iPasswordLength = 8;
        $sCharsetPassword = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789][{};:?.>,<!@#$%^&*()-_=+|';
        $sRandString = '';

        for ($i = 0; $i < $iPasswordLength; ++$i) {
            $sRandString .= $sCharsetPassword[mt_rand(0, strlen($sCharsetPassword) - 1)];
        }

        return $sRandString;
    }
    

    public static function crypt_file($root = "./", $name)
    {
        /* leer el código fuente PHP */
        $source_code = file_get_contents("$root$name");

        /* crear la versión encriptada */
        $redistributable_key = blenc_encrypt($source_code, "./build/$name");

        /* leer cuál es el fichero key_file */
        $key_file = ini_get('blenc.key_file');

        /* grabar la clave redistribuible */
        file_put_contents("security", $redistributable_key, FILE_APPEND);
    }
}
