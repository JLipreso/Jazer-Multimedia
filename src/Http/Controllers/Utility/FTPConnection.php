<?php

namespace Jazer\Multimedia\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * App\Http\Controllers\Utility\FTPConnection::connect();
 */

class FTPConnection extends Controller
{
    public static function connect() {
        $ftpcon         = ftp_connect(config('jtmultimediaconfig.ftp_ip'));
        if (!$ftpcon) {
            return false;
        }
        $ftplogin = ftp_login($ftpcon, config('jtmultimediaconfig.ftp_username'), config('jtmultimediaconfig.ftp_password'));
        if (!$ftplogin) {
            ftp_close($ftpcon);
            return false;
        }
        else {
            return $ftpcon;
        }
    }
    
}