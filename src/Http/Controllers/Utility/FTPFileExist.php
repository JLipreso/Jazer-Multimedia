<?php

namespace Jazer\Multimedia\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * \Jazer\Multimedia\Http\Controllers\Utility\FTPFileExist::isExist();
 */

class FTPFileExist extends Controller
{
    public static function isExist($ftpConn, $remoteFilePath) {
        return ftp_size($ftpConn, "public_html/" . $remoteFilePath) != -1;
    }
}