<?php

namespace Jazer\Multimedia\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Photo extends Controller
{
    public static function upload(Request $request) {

        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return [
                'success' => false,
                'message' => 'Invalid image file'
            ];
        }

        $image = $request->file('image');

        $ext           = $ext = $image->guessExtension() ?: 'jpg'; 
        $localPath     = $image->getRealPath();
        $reference_id  = \Jazer\Multimedia\Http\Controllers\Utility\ReferenceID::create('IMG');
        $dateFolder    = date('Y-m-d');
        $filename      = $reference_id . '.' . $ext;
        $ftpSubDir     = config('jtmultimediaconfig.ftp_directory') . "/" . $dateFolder;

        $ftpcon         = ftp_connect(config('jtmultimediaconfig.ftp_ip'));
        if (!$ftpcon) {
            return [
                'success' => false,
                'message' => 'Could not connect to FTP server'
            ];
        }

        $ftplogin = ftp_login($ftpcon, config('jtmultimediaconfig.ftp_username'), config('jtmultimediaconfig.ftp_password'));
        if (!$ftplogin) {
            ftp_close($ftpcon);
            return [
                'success' => false,
                'message' => 'FTP login failed'
            ];
        }

        ftp_pasv($ftpcon, true);

        $remotePath = $ftpSubDir . '/' . $filename;
        $upload     = ftp_put($ftpcon, "public_html/" . $remotePath, $localPath, FTP_BINARY);

        ftp_close($ftpcon);

        if ($upload) {
            return [
                'success'      => true,
                'reference_id' => $reference_id,
                'filename'     => $filename,
                'remotePath'   => $remotePath
            ];
        } else {
            return [
                'success'      => false,
                'reference_id' => $reference_id,
                'message'      => 'FTP upload failed'
            ];
        }
    }
}