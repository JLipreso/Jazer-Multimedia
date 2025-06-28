<?php


namespace Jazer\Multimedia\Http\Controllers\Utility;

use App\Http\Controllers\Controller;

/**
 * \Jazer\Multimedia\Http\Controllers\Utility\CreateFolderIfNotExist::create($ftp_conn);
 */

class CreateFolderIfNotExist extends Controller
{
    public static function create($ftp_conn, $ftpRoot, $folder_path) {

        

        $folder_path    = rtrim($folder_path, '/');
        $folderList     = ftp_nlist($ftp_conn, $ftpRoot . config('jtmultimediaconfig.ftp_directory') . '/');
        $targetPath     = $ftpRoot . config('jtmultimediaconfig.ftp_directory') .'/'. $folder_path;

        if (!in_array($targetPath, $folderList)) {
            if (ftp_mkdir($ftp_conn, $targetPath)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}



